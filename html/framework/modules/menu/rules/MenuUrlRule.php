<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.12.17
 * Time: 10:17
 */

namespace app\modules\menu\rules;

use elfuvo\menu\models\Menu;
use elfuvo\menu\rules\MenuUrlRuleInterface;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRule;

/**
 * Class MenuUrlRule
 *
 * @package elfuvo\menu\rules
 */
class MenuUrlRule extends UrlRule implements MenuUrlRuleInterface
{
    /**
     * @var array
     */
    private static $menu = [];

    /**
     * @var null|array
     */
    private static $currentRule;

    /**
     * @param null|string $language
     *
     * @return array|Menu[]|mixed
     */
    public static function menu($language = null)
    {
        if (!$language) {
            $language = Yii::$app->language;
        }
        if (!self::$menu) {
            $key = [
                __CLASS__,
                __FILE__,
                $language,
            ];

            $dependency = new TagDependency([
                'tags' => [
                    Menu::class,
                ],
            ]);

            self::$menu = Yii::$app->getCache()->get($key);

            if (self::$menu === false) {
                self::$menu = Menu::find()->select([
                    'id',
                    'url',
                    'route',
                    'queryParams',
                    'language',
                    'parentId',
                ])->language($language)
                    ->active()
                    ->andWhere([
                        'OR',
                        ['type' => Menu::TYPE_MODULE],
                        ['type' => Menu::TYPE_BREADCRUMB],
                    ])
                    ->orderBy(['depth' => SORT_DESC, 'position' => SORT_ASC])
                    ->asArray()
                    ->all();

                self::$menu = ArrayHelper::map(self::$menu, 'id', function ($row) {
                    $row['match'] = '#^' . $row['url'] . '$#';
                    if (preg_match_all('/<([\w._-]+):?([^>]+)?>/', $row['url'], $matches)) {
                        $row['needParams'] = $row['matchMap'] = [];
                        // params that needs on url creation
                        foreach ($matches[1] as $key => $param) {
                            $fullPart = $matches[0][$key]; // "<id:\d+>"
                            $matchPart = $matches[2][$key];// "\d+"
                            $row['needParams'][$param] = $fullPart;
                            array_push($row['matchMap'], $param);
                            if (strlen($matchPart) > 1) {
                                $row['match'] = preg_replace(
                                    '#' . preg_quote($fullPart) . '#',
                                    '([' . $matchPart . ']+)',
                                    $row['match'],
                                    1
                                );
                            } else {
                                $row['match'] = preg_replace(
                                    '#' . preg_quote($fullPart) . '#',
                                    '([^\/]+)',
                                    $row['match'],
                                    1
                                );
                            }

                        }
                        unset($matches);
                    }
                    // convert queryParams from string to associated array
                    parse_str($row['queryParams'], $queryParams);
                    $row['queryParams'] = $queryParams;

                    return $row;
                });

                Yii::$app->getCache()->set($key, self::$menu, null, $dependency);
            }
        }

        return self::$menu;
    }

    /**
     * @return string
     */
    protected function getSuffix()
    {
        return $this->suffix === null ? Yii::$app->getUrlManager()->suffix : $this->suffix;
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     *
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        $rule = null;

        $language = ArrayHelper::remove($params, 'language');
        $params['section'] = Yii::$app->request->get('section', $params['section'] ?? Menu::SECTION_DEFAULT);

        // try found some item in menu list
        foreach (self::menu($language) as $menu) {
            // if we have same $rule['route'] as $route
            if ($menu['route'] == $route) {
                // check correlation $params & $rule['queryParams']
                // $params must be bigger than $rule['queryParams']
                if (!empty($params)) {

                    // skip menu items with empty queryParams & needParams
                    if (empty($menu['queryParams']) && !isset($menu['needParams'])) {
                        continue;
                    }

                    // check that all needed params exists in $params
                    if (isset($menu['needParams'])) {
                        $intersect = array_intersect_key($menu['needParams'], $params);
                        if (count($intersect) != count($menu['needParams'])) {
                            continue;
                        }
                        // this menu item contains all needed params
                        $rule = $menu;
                        unset($intersect);
                    }

                    // check that all needed queryParams in $params
                    // if it not empty
                    if ($menu['queryParams']) {
                        // check keys intersection
                        $intersect = array_intersect_key($menu['queryParams'], $params);

                        if (count($intersect) != count($menu['queryParams'])) {
                            continue;
                        }
                        unset($intersect);
                        // completely intersection by keys,
                        // check intersection by values
                        $intersect = 0;
                        foreach ($params as $param => $value) {
                            if (isset($menu['queryParams'][$param]) && $menu['queryParams'][$param] == $value) {
                                $intersect++;
                            }
                        }
                        if (count($menu['queryParams']) == $intersect) {
                            $rule = $menu;
                            break;
                        }
                    }
                } elseif (empty($menu['queryParams']) && !isset($menu['needParams'])) {
                    $rule = $menu;
                }
            }
        }

        if ($rule === null) {
            return false;
        } else {
            // replace placeholders in url to it value
            // /brand/news/<id:\d+> => /brand/news/2
            if (isset($rule['needParams'])) {
                foreach ($rule['needParams'] as $param => $placeholder) {
                    $rule['url'] = preg_replace('#' . preg_quote($placeholder) . '#i',
                        $params[$param],
                        $rule['url']
                    );
                    unset($params[$param]);
                }
            }
            if (!empty($rule['queryParams'])) {
                foreach ($rule['queryParams'] as $param => $value) {
                    if (isset($params[$param])) {
                        unset($params[$param]);
                    }
                }
            }

            return $rule['language'] . '/' . $rule['url'] .
                $this->getSuffix() .
                ($params ? '?' . http_build_query($params) : '');
        }
    }

    /**
     * @param $path
     *
     * @return null|array
     */
    protected function findMenu($path)
    {
        $rule = null;
        foreach (self::menu() as $menu) {
            if (preg_match($menu['match'], $path, $match)) {
                $menu['params'] = $menu['queryParams'];
                if (isset($menu['matchMap'])) {
                    foreach ($menu['matchMap'] as $key => $param) {
                        $menu['params'][$param] = ArrayHelper::getValue($match, ($key + 1));
                    }
                }

                $rule = $menu;
                break;
            }
        }

        return $rule;
    }

    /**
     * @param array $arr
     * @param array $arr2
     *
     * @return array
     */
    private function mergeGetVars(array $arr, array $arr2)
    {
        $result = [];
        $keys = array_unique(array_merge(array_keys($arr), array_keys($arr2)));
        foreach ($keys as $key) {
            if (isset($arr[$key]) && is_array($arr[$key])) {
                $result[$key] = $this->mergeGetVars($arr[$key],
                    (isset($arr2[$key]) && is_array($arr2[$key]) ? $arr2[$key] : []));
            } elseif (isset($arr[$key]) && isset($arr2[$key])) {
                $result[$key] = $arr2[$key];
            } elseif (isset($arr[$key])) {
                $result[$key] = $arr[$key];
            } elseif (isset($arr2[$key])) {
                $result[$key] = $arr2[$key];
            }
        }

        return $result;
    }

    /**
     * @param UrlManager $manager
     * @param Request $request
     *
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if ($this->getSuffix() > '') {
            $pathInfo = preg_replace('/' . $this->getSuffix() . '$/i', '', $pathInfo);
        }

        if (!preg_match($this->pattern, $pathInfo, $matches)) {
            return false;
        }

        $matches = $this->substitutePlaceholderNames($matches);

        $rule = $this->findMenu($matches['path']);

        if ($rule === null) {
            return false;
        }
        self::$currentRule = $rule;

        // merge GET variables with current menu params
        $params = $this->mergeGetVars(Yii::$app->request->getQueryParams(), $rule['params']);

        return [
            $rule['route'],
            $params,
        ];
    }

    /**
     * @return array|null
     */
    public static function getCurrentRule(): ?array
    {
        return self::$currentRule;
    }

    /**
     * @param array $menu
     */
    public static function setCurrentRule(array $menu)
    {
        if ($menu['url']) {
            self::$currentRule = $menu;
        }
    }
}