<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 29.12.17
 * Time: 11:11
 */

namespace app\modules\menu\widgets;

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\rules\ProductUrlRule;
use elfuvo\menu\models\Menu;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs as BaseWidget;

/**
 * Class BreadcrumbsWidget
 *
 * @package app\extensions\menu\widgets
 */
class BreadcrumbsWidget extends BaseWidget
{
    const BREADCRUMB_KEY = 'menu.breadcrumbs';

    const SYNTHETIC_ROUTES = [
        'product/catalog/view',
    ];

    /**
     * @var bool
     */
    public $homeLink = false;

    /**
     * how to render last link - as link or simple text
     *
     * @var bool
     */
    public $skipLastLink = true;

    /**
     * @var bool
     */
    public $hideLastLink = false;

    /**
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->links = ArrayHelper::merge($this->generate(), $this->links);
    }

    /**
     * @return array
     */
    protected function generate()
    {

        $hideBreadcrumbs = ArrayHelper::getValue($this->getView()->params, 'hideBreadcrumbs');
        if ($hideBreadcrumbs) {
            return [];
        }

        if ($links = self::getSavedBreadcrumbs()) {
            return $links;
        }

        $links = [
            [
                'label' => Yii::t('system', 'Home page'),
                'url' => Url::home(),
            ],
        ];

        $list = Menu::find()->language()
            ->active()
            ->asNavChain();

        if (Yii::$app->request->get('section') == 'top' &&
            (Yii::$app->request->get('brandId') ||
                in_array(Yii::$app->controller->action->getUniqueId(),
                    ['product/brand/index']))
        ) {
            $list[] = [
                'url' => 'product/brand/index',
                'title' => 'Наши бренды',
                'type' => Menu::TYPE_MODULE,
            ];
        }

        if (in_array(Yii::$app->controller->action->getUniqueId(),
            ['product/usage/items', 'product/usage/section', 'product/usage/view'])
        ) {
            $list[] = [
                'url' => 'product/usage/index',
                'title' => 'Сферы применения',
                'type' => Menu::TYPE_MODULE,
            ];
        }

        if (Yii::$app->request->get('section') == 'left' &&
            (Yii::$app->request->get('brandId') ||
                in_array(Yii::$app->controller->action->getUniqueId(),
                    ['product/brand/section', 'product/brand/items']))
        ) {
            $list[] = [
                'url' => 'product/brand/index',
                'title' => 'Наши бренды',
                'type' => Menu::TYPE_MODULE,
            ];
        }

        if (Yii::$app->request->get('section') == 'left' &&
            Yii::$app->request->get('setId') || Yii::$app->request->get('categoryId')
        ) {
            $list[] = [
                'url' => 'product/set/index',
                'title' => 'Готовые торговые решения',
                'type' => Menu::TYPE_MODULE,
                'customQueryParams' => ['categoryId' => null],
            ];
        }

        $productList = ProductUrlRule::getBreadCrumbs();
        foreach ($list as $key => $item) {
            // dynamic url, skip it for breadcrumb, must be set manually from view
            if (Menu::TYPE_BREADCRUMB && preg_match('#\<([^>]+)\>#', $item['url'])) {
                continue;
            }

            if ($item['type'] == Menu::TYPE_VOID) {
                $links[] = [
                    'label' => $item['title'],
                    'url' => null,
                ];
            } /*elseif ($this->hideLastLink && ($key + 1) >= count($list) && empty($productList)) {
                continue;
            }*/ elseif ($this->skipLastLink && ($key + 1) >= count($list)) {
                $links[] = $item['title'];
            } else {
                if (isset($item['customQueryParams'])) {
                    $links[] = [
                        'label' => $item['title'],
                        'url' => Url::to(['/' . $item['url']] + $item['customQueryParams']),
                    ];
                } else {
                    $links[] = [
                        'label' => $item['title'],
                        'url' => Url::to(['/' . $item['url']]),
                    ];
                }
            }
        }

        if ($productList) {
            $links = ArrayHelper::merge($links, $productList);
        }
        self::saveBreadcrumbs($links);

        if ($this->hideLastLink) {
            array_pop($links);
        }

        // add breadcrumbs items from view
        $viewLinks = ArrayHelper::getValue($this->getView()->params, 'breadcrumbs');
        if ($viewLinks) {
            $links = ArrayHelper::merge($links, $viewLinks);
        }

        return $links;
    }


    /**
     * @return array
     */
    protected static function getSavedBreadcrumbs()
    {
        $links = [];
        if (in_array(Yii::$app->controller->action->getUniqueId(), self::SYNTHETIC_ROUTES)) {
            $links = Yii::$app->session->get(self::BREADCRUMB_KEY, []);
            // create breadcrumbs if it empty
            if (!$links && $productAlias = Yii::$app->request->get('alias')) {
                $brand = ProductBrand::find()->select([
                    ProductBrand::tableName() . '.[[id]]',
                    ProductBrand::tableName() . '.[[title]]'
                ])->joinWith('products', false, 'INNER JOIN')
                    ->where([
                        Product::tableName() . '.[[alias]]' => $productAlias,
                    ])->asArray()
                    ->one();

                $links = [
                    [
                        'label' => Yii::t('system', 'Home page'),
                        'url' => Url::home(),
                    ],
                    [
                        'url' => ['/product/brand/index', 'section' => 'top'],
                        'label' => 'Каталог',
                    ],
                    [
                        'url' => ['/product/brand/index', 'section' => 'top'],
                        'label' => 'Наши бренды',
                    ],
                ];
                if ($brand) {
                    array_push($links, [
                        'url' => ['/product/brand/view', 'brandId' => $brand['id']],
                        'label' => $brand['title'],
                    ]);
                    array_push($links, [
                        'url' => ['/product/brand/items', 'brandId' => $brand['id']],
                        'label' => 'Все товары',
                    ]);
                }
            }
        }

        return $links;
    }

    /**
     * @param array $breadcrumbs
     */
    protected static function saveBreadcrumbs($breadcrumbs)
    {
        if (!in_array(Yii::$app->controller->action->getUniqueId(), self::SYNTHETIC_ROUTES)) {
            Yii::$app->session->set(self::BREADCRUMB_KEY, $breadcrumbs);
        }

    }
}