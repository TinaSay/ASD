<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 15.03.18
 * Time: 14:40
 */

namespace app\modules\product\rules;

use app\modules\menu\rules\MenuUrlRule;
use app\modules\product\interfaces\ProductTitleInterface;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\search\ProductCatalogSearch;
use elfuvo\menu\models\Menu;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRule;

/**
 * Class ProductUrlRule
 *
 * @package app\modules\product\rules
 */
class ProductUrlRule extends UrlRule
{
    /**
     * @var array
     */
    protected static $breadcrumbs = [];

    /**
     * @var array
     */
    protected static $params2class = [];

    /**
     * @var string
     */
    protected $basePath = 'catalog';

    /**
     * @var array
     */
    public $routes = [
        'search' => [
            'class' => ProductCatalogSearch::class,
            'route' => 'product/catalog/search',
            'allowParams' => [],
            'allowQueryParams' => ['page'],
            'path' => '/search',
            'prePath' => '/catalog',
        ],
        'usages' => [
            'class' => ProductCatalogSearch::class,
            'route' => 'product/usage/index',
            'allowParams' => [],
            'allowQueryParams' => [],
            'path' => '/usages',
            'prePath' => '/catalog',
        ],
        'brand/([\w\-\_\d]+)' => [
            'id' => 'brandId',
            'class' => ProductBrand::class,
            'route' => 'product/brand/view',
            'allowParams' => ['brandId'],
        ],
        'brand/([\w\-\_\d]+)/all' => [
            'id' => 'brandId',
            'path' => '/all',
            'class' => ProductBrand::class,
            'route' => 'product/brand/items',
            'allowParams' => ['brandId'],
            'allowQueryParams' => ['page'],
        ],
        'section/([\w\-\_\d]+)' => [
            'id' => 'sectionId',
            'class' => ProductSection::class,
            'route' => 'product/brand/section',
            'allowParams' => ['brandId', 'sectionId'],
            'allowQueryParams' => ['page'],
        ],
        'promo/([\w\-\_\d]+)' => [
            'id' => 'promoId',
            'class' => ProductPromo::class,
            'route' => 'product/promo/index',
            'allowParams' => ['brandId', 'promoId'],
        ],
        'category/([\w\-\_\d]+)' => [
            'id' => 'categoryId',
            'class' => ProductUsage::class,
            'route' => 'product/set/index',
            'allowParams' => ['categoryId'],
            //  'skipBreadcrumb' => true,
        ],
        'usage/([\w\-\_\d]+)' => [
            'id' => 'usageId',
            'class' => ProductUsage::class,
            'route' => 'product/usage/view',
            'allowParams' => ['usageId', 'sectionId'],
            'allowQueryParams' => [],
        ],
        'usage/([\w\-\_\d]+)/all' => [
            'id' => 'usageId',
            'path' => '/all',
            'class' => ProductUsage::class,
            'route' => 'product/usage/items',
            'allowParams' => ['usageId', 'sectionId'],
            'allowQueryParams' => ['page'],
        ],
        'partition/([\w\-\_\d]+)' => [
            'id' => 'partitionId',
            'class' => ProductSection::class,
            'route' => 'product/usage/section',
            'allowParams' => ['usageId', 'partitionId'],
            'allowQueryParams' => ['page'],
        ],
        'set/([\w\-\_\d]+)' => [
            'id' => 'setId',
            'class' => ProductSet::class,
            'route' => 'product/set/view',
            'allowParams' => ['usageId', 'setId'],
        ],
        'set/([\w\-\_\d]+)/all' => [
            'id' => 'setId',
            'path' => '/all',
            'class' => ProductSet::class,
            'route' => 'product/set/items',
            'allowParams' => ['usageId', 'setId'],
            'allowQueryParams' => ['page'],
        ],
        'set/([\w\-\_\d]+)/order' => [
            'id' => 'setId',
            'path' => '/order',
            'class' => ProductSet::class,
            'route' => 'product/set/order',
            'allowParams' => ['usageId', 'setId'],
        ],
    ];

    /**
     * @var array
     */
    public $ignorePaths = [
        //'#\/catalog#i',
        '#\/sets#i',
        '#\/brands#i',
        '#\/usages#i',
    ];

    /**
     * @var array
     */
    static $alias;

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     *
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        $language = ArrayHelper::remove($params, 'language');

        $params = ArrayHelper::merge(Yii::$app->request->get(), $params);
        $path = null;
        $queryParams = [];
        // try found some item in menu list
        foreach ($this->routes as $pattern => $item) {
            // if we have same $rule['route'] as $route

            if ($item['route'] == $route && isset($item['id']) && isset($params[$item['id']])) {
                $path = $this->basePath;
                if (isset($item['prePath']) &&
                    !preg_match('#' . preg_quote($item['prePath']) . '#', Yii::$app->request->pathInfo)) {
                    continue;
                }

                $path .= isset($item['prePath']) ? preg_replace('#' . preg_quote($this->basePath) . '#i', '',
                    trim($item['prePath'], '/')) : '';
                foreach ($item['allowParams'] as $paramId) {
                    $param = preg_replace('#Id#i', '', $paramId);
                    $modelClass = $this->getModelClassForParam($paramId);
                    if (isset($params[$paramId])) {
                        $path .= '/' . $param . '/' . $this->getAliasFromId($params[$paramId], $modelClass);
                    }
                }
                $path .= $item['path'] ?? '';
                if (isset($item['allowQueryParams'])) {
                    foreach ($item['allowQueryParams'] as $param) {
                        if (isset($params[$param])) {
                            $queryParams[$param] = $params[$param];
                        }
                    }
                }
                break;
            } elseif ($item['route'] == $route && isset($item['path'])) {
                $path = $item['prePath'] ?? '';
                $path .= $item['path'];
                if (isset($item['allowQueryParams'])) {
                    foreach ($item['allowQueryParams'] as $param) {
                        if (isset($params[$param])) {
                            $queryParams[$param] = $params[$param];
                        }
                    }
                }
                break;
            }
        }

        if ($path === null) {
            return false;
        } else {
            return $language . '/' . trim($path, '/') .
                (count($queryParams) > 0 ? '?' . http_build_query($queryParams) : '');
        }
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

        if (!preg_match($this->pattern, $pathInfo, $matches)) {
            return false;
        }

        $matches = $this->substitutePlaceholderNames($matches);
        $this->basePath = ArrayHelper::getValue($matches, 'basePath', 'catalog');

        $this->basePath = preg_replace_callback($this->ignorePaths, function () {
            return '';
        }, $this->basePath);

        $routes = array_reverse($this->routes);
        $route = null;
        $params = [];
        foreach ($routes as $pattern => $rule) {
            if (preg_match('#' . $pattern . '#i', $matches['path'], $aliasMatch)) {
                if (isset($rule['prePath']) &&
                    !preg_match('#' . preg_quote($rule['prePath']) . '#', $matches['path']) &&
                    !preg_match('#' . preg_quote($this->basePath) . '#', $rule['prePath'])) {
                    continue;
                }
                $alias = (string)array_pop($aliasMatch);
                if (!$route) {
                    $route = $rule['route'];
                }
                if (!isset($rule['skipBreadcrumb'])) {
                    array_push(self::$breadcrumbs,
                        $rule + ['idValue' => $this->getIdFromAlias($alias, $rule['class'])]);
                }
                if (isset($rule['id'])) {
                    $params[$rule['id']] = $this->getIdFromAlias($alias, $rule['class']);
                }
            }
        }
        if (!$route) {
            return false;
        }
        $originalBasePath = ArrayHelper::getValue($matches, 'basePath', 'catalog');
        $menu = Menu::find()->where(['url' => $originalBasePath])
            ->orWhere(['url' => $this->basePath])
            ->orderBy(['depth' => SORT_DESC])
            ->limit(1)->one()->toArray();

        if ($menu) {
            MenuUrlRule::setCurrentRule($menu);
            parse_str($menu['queryParams'], $menuParams);
            $params = ArrayHelper::merge($params, $menuParams);
        }

        // merge GET variables with current menu params
        $params = $this->mergeGetVars(Yii::$app->request->getQueryParams(), $params);

        return [
            $route,
            $params,
        ];
    }

    /**
     * @return array
     */
    public static function getBreadCrumbs()
    {
        $list = [];
        $reversed = array_reverse(self::$breadcrumbs);
        foreach ($reversed as $rule) {
            $model = Yii::createObject($rule['class']);
            if ($model instanceof ProductTitleInterface) {
                if (isset($rule['id'])) {
                    array_push($list, [
                        'label' => $model->getMenuTitle($rule['idValue'], ($rule['path'] ?? null)),
                        'url' => Url::to(['/' . $rule['route'], $rule['id'] => $rule['idValue']]),
                    ]);
                } else {
                    array_push($list, [
                        'label' => $model->getMenuTitle($rule['idValue'], ($rule['path'] ?? null)),
                        'url' => Url::to(['/' . $rule['route']]),
                    ]);
                }
            }
        }

        return $list;
    }

    /**
     * @param $alias
     * @param $model
     *
     * @return null|int
     */
    protected function getIdFromAlias($alias, $model)
    {
        if (preg_match('#^([\d]+)-#', $alias, $matches)) {
            return $matches[1];
        }

        return ArrayHelper::getValue(self::getAliases(), [$model, $alias]);
    }

    /**
     * @param $id
     * @param $model
     *
     * @return string
     */
    protected function getAliasFromId($id, $model)
    {
        $alias = '';
        if ($aliases = ArrayHelper::getValue(self::getAliases(), $model)) {
            $aliases = array_flip($aliases);
            $alias = ArrayHelper::getValue($aliases, $id);
        }

        if (!$alias) {
            $alias = $id . '-';
            if (preg_match('#\/Product([\w]+)#', $model, $matches)) {
                $alias .= strtolower($matches[1]);
            } else {
                $alias .= 'product';
            }
        }

        return $alias;
    }

    /**
     * @return array
     */
    protected function getAliases()
    {
        if (self::$alias) {
            return self::$alias;
        }
        $key = [
            'product.alias',
        ];

        $dependency = new TagDependency([
            'tags' => [
                //  Product::class,
                ProductBrand::class,
                ProductSection::class,
                ProductUsage::class,
                ProductSet::class,
                ProductPromo::class,
            ],
        ]);

        if (!self::$alias && (self::$alias = Yii::$app->cache->get($key)) === false) {
            /*self::$alias[Product::class] = Product::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => Product::HIDDEN_NO])
                ->indexBy('alias')
                ->column();*/

            self::$alias[ProductSection::class] = ProductSection::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => ProductSection::HIDDEN_NO])
                ->andWhere(['>', 'alias', ''])
                ->indexBy('alias')
                ->column();

            self::$alias[ProductBrand::class] = ProductBrand::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => ProductBrand::HIDDEN_NO])
                ->andWhere(['>', 'alias', ''])
                ->indexBy('alias')
                ->column();

            self::$alias[ProductUsage::class] = ProductUsage::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => ProductUsage::HIDDEN_NO])
                ->andWhere(['>', 'alias', ''])
                ->indexBy('alias')
                ->column();

            self::$alias[ProductSet::class] = ProductSet::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => ProductSet::HIDDEN_NO])
                ->andWhere(['>', 'alias', ''])
                ->indexBy('alias')
                ->column();

            self::$alias[ProductPromo::class] = ProductPromo::find()->select([
                'id',
                'alias',
            ])->where(['hidden' => ProductPromo::HIDDEN_NO])
                ->andWhere(['>', 'alias', ''])
                ->indexBy('alias')
                ->column();

            Yii::$app->cache->set($key, self::$alias, null, $dependency);
        }

        return self::$alias;
    }

    /**
     * @param $param
     *
     * @return string|null
     */
    protected function getModelClassForParam($param)
    {
        if (!self::$params2class) {
            foreach ($this->routes as $rule) {
                if (isset($rule['id']) && isset($rule['class'])) {
                    self::$params2class[$rule['id']] = $rule['class'];
                }
            }
        }

        return ArrayHelper::getValue(self::$params2class, $param);
    }
}