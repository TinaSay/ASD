<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 14:17
 */

namespace app\modules\product\services;

use app\modules\auth\models\Auth;
use app\modules\product\components\SoapClientComponent;
use app\modules\product\dto\FileDto;
use app\modules\product\dto\ProductDto;
use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductClientCategory;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductProperty;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\ProductUsageRel;
use krok\storage\models\Storage;
use Yii;
use yii\base\BaseObject;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\web\UploadedFile;

/**
 * Class ImportService
 * @package app\modules\product\services
 */
class ImportService extends BaseObject
{
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var bool
     */
    protected $log = false;

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var SoapClientComponent
     */
    protected $component;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @var array
     */
    protected $brandsUidToId = [];

    /**
     * @var array
     */
    protected $sectionsUidToId = [];

    /**
     * @var array
     */
    protected $usagesUidToId = [];

    /**
     * @var array
     */
    protected $clientCategoriesUidToId = [];

    /**
     * @var array
     */
    protected $productUidToId = [];

    /**
     * @var array
     */
    protected $relatedProducts = [];

    /**
     * @var string
     */
    public $storageBasePath = '@public/storage';

    /**
     * @var string
     */
    public $logFilePath = '@runtime/logs/product.import.log';

    /**
     * @var array
     */
    protected $stat = [
        'date' => '',
        'products.created' => 0,
        'products.updated' => 0,
        'products.deleted' => 0,
        'file.created' => [],
        'file.deleted' => [],
        'file.skip' => [],
        'errors' => [],
    ];

    /**
     * ImportController constructor.
     *
     * @param Storage $storage
     * @param SoapClientComponent $component
     * @param array $config
     */
    public function __construct(
        Storage $storage,
        SoapClientComponent $component,
        array $config = []
    ) {
        parent::__construct($config);

        $this->storage = $storage;
        $this->component = $component;

        $this->storageBasePath = Yii::getAlias($this->storageBasePath);

        $user = Auth::findOne(['login' => 'webmaster']);

        Yii::$app->user->login($user);

        ini_set('memory_limit', '256M');
    }

    /**
     * @return int
     */
    public function import()
    {
        $this->clearLog();

        $this->stat['date'] = date("Y-m-d h:i:s");
        $this->properties = ProductProperty::find()->select([
            'id',
            'code',
        ])->indexBy('code')->column();

        $this->productUidToId = Product::find()->select([
            'id',
            'uuid',
        ])->indexBy('uuid')->column();
        try {
            $this->consoleLog('Start import brands');
            $this->brandsUidToId = $this->importBrands();
            $this->consoleLog('Start import sections');
            $this->sectionsUidToId = $this->importSections();
            $this->consoleLog('Start import usages');
            $this->usagesUidToId = $this->importUsages();
            $this->consoleLog('Start import client categories');
            $this->clientCategoriesUidToId = $this->importClientCategories();
            $this->consoleLog('Start import active products');
            $this->importActiveProducts();
            $this->consoleLog('Start import promos');
            $this->importPromos();
            $this->consoleLog('Start import products sets');
            $this->importProductSets();
            $this->consoleLog('Start import related products');
            $this->importRelatedProducts();

            Yii::$app->cache->flush();

        } catch (\Exception $e) {
            $this->stat['errors'] = array_merge([$e->getMessage()], $this->stat['errors']);
        }
        $this->stat['errors'] = array_merge($this->stat['errors'], $this->component->getErrors());
        $this->saveLog();

        if (YII_DEBUG !== true) {
            $this->component->clearFiles();
        }

        return true;
    }

    /**
     * @return array
     */
    public function importBrands()
    {
        $list = [];
        if ($brands = $this->component->getBrands()) {
            foreach ($brands as $dto) {
                $model = ProductBrand::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model) {
                        $this->consoleLog(Console::ansiFormat('Delete brand: ' . $model->title . ' (' . $model->id . ')',
                            [Console::FG_YELLOW]));
                        $model->delete();
                    }
                    continue;
                }
                if ($model) {
                    $dto->setId($model->id);
                    $model->setAttributes([
                        'title' => $dto->getTitle(),
                        'description' => $dto->getDescription(),
                        'text' => $dto->getText(),
                        'position' => $dto->getPosition(),
                    ]);
                } else {
                    $model = new ProductBrand([
                        'uuid' => $dto->getUid(),
                        'title' => $dto->getTitle(),
                        'description' => $dto->getDescription(),
                        'text' => $dto->getText(),
                        'hidden' => ProductBrand::HIDDEN_NO,
                        'position' => $dto->getPosition(),
                    ]);
                }
                $model->setScenario(ProductBrand::SCENARIO_IMPORT);

                // attach logo
                if ($logo = $dto->getLogo()) {
                    $this->attachFile($model, $logo, 'logo', ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                }
                // attach presentation
                if ($presentation = $dto->getPresentation()) {
                    $this->attachFile($model, $presentation, 'presentation');
                }
                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }

                $dto->setId($model->id);
                unset($model);
                // need for future product links
                $list[$dto->getUid()] = $dto->getId();
            }
        }

        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($list));

        return $list;
    }

    /**
     * @return array
     */
    protected function importUsages()
    {
        $list = [];
        if ($usages = $this->component->getUsages()) {
            foreach ($usages as $dto) {
                $model = ProductUsage::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model) {
                        $this->consoleLog(Console::ansiFormat('Delete usage: ' . $model->title . ' (' . $model->id . ')',
                            [Console::FG_YELLOW]));
                        $model->delete();
                    }
                    continue;
                }
                if ($model) {
                    $dto->setId($model->id);
                    $model->setAttributes([
                        'title' => $dto->getTitle(),
                        'position' => $dto->getPosition(),
                    ]);
                } else {
                    $model = new ProductUsage([
                        'uuid' => $dto->getUid(),
                        'title' => $dto->getTitle(),
                        'position' => $dto->getPosition(),
                        'hidden' => ProductUsage::HIDDEN_NO,
                    ]);
                }
                $model->setScenario(ProductUsage::SCENARIO_IMPORT);

                // attach icon
                if ($icon = $dto->getIcon()) {
                    $this->attachFile($model, $icon, 'icon', ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                }

                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }

                $dto->setId($model->id);
                unset($model);
                // need for future product links
                $list[$dto->getUid()] = $dto->getId();
            }
        }

        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($list));

        return $list;
    }

    /**
     * @return array
     */
    protected function importClientCategories()
    {
        $list = [];
        if ($clientCategories = $this->component->getClientCategories()) {
            foreach ($clientCategories as $dto) {
                $model = ProductClientCategory::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model) {
                        $this->consoleLog(Console::ansiFormat('Delete client category: ' . $model->title . ' (' . $model->id . ')',
                            [Console::FG_YELLOW]));
                        $model->delete();
                    }
                    continue;
                }
                if ($model) {
                    $dto->setId($model->id);
                    $model->setAttributes([
                        'title' => $dto->getTitle(),
                    ]);
                } else {
                    $model = new ProductClientCategory([
                        'uuid' => $dto->getUid(),
                        'title' => $dto->getTitle(),
                        'hidden' => ProductClientCategory::HIDDEN_NO,
                    ]);
                }
                $model->setScenario(ProductClientCategory::SCENARIO_IMPORT);

                // attach icon
                if ($icon = $dto->getIcon()) {
                    $this->attachFile($model, $icon, 'icon', ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                }

                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }

                $dto->setId($model->id);
                unset($model);
                // need for future product links
                $list[$dto->getUid()] = $dto->getId();
            }
        }
        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($list));

        return $list;
    }

    /**
     * @return array
     */
    protected function importSections()
    {
        $list = [];
        $depthMap = [];
        if ($sections = $this->component->getSections()) {
            foreach ($sections as $dto) {
                $model = ProductSection::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model && !$model->children) {
                        $this->consoleLog(Console::ansiFormat('Delete section: ' . $model->title . ' (' . $model->id . ')',
                            [Console::FG_YELLOW]));
                        $model->delete();
                    }
                    continue;
                }
                if ($model) {
                    $dto->setId($model->id);
                    $depthMap[$dto->getUid()] = $model->depth;
                } else {
                    $model = new ProductSection([
                        'uuid' => $dto->getUid(),
                        'depth' => $dto->getParentUid() && isset($depthMap[$dto->getParentUid()]) ?
                            $depthMap[$dto->getParentUid()] + 1 : 0,
                    ]);

                    $depthMap[$dto->getUid()] = $model->depth;
                }
                $model->setScenario(ProductSection::SCENARIO_IMPORT);

                if ($dto->getParentUid() && isset($list[$dto->getParentUid()])) {
                    $model->setAttribute('parentId', $list[$dto->getParentUid()]);
                } else {
                    // reset parent
                    $model->setAttribute('parentId', null);
                }

                if ($dto->getBrands()) {
                    $brandId = [];
                    foreach ($dto->getBrands() as $baseDto) {
                        if (isset($this->brandsUidToId[$baseDto->getUid()])) {
                            array_push($brandId, $this->brandsUidToId[$baseDto->getUid()]);
                        }
                    }
                    $model->brandId = $brandId;
                } elseif ($dto->getParentUid() && $model->parent) {
                    $model->brandId = $model->parent->brandId;
                }

                $model->setAttributes([
                    'title' => $dto->getTitle(),
                    'hidden' => ProductSection::HIDDEN_NO,
                    'position' => $dto->getPosition(),
                ]);
                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }

                $dto->setId($model->id);
                unset($model);
                // need for future product links
                $list[$dto->getUid()] = $dto->getId();
            }
        }

        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($list));

        return $list;
    }

    /**
     * import active products
     */
    protected function importActiveProducts()
    {
        if ($products = $this->component->getActiveProducts()) {
            $allProductsUid = Product::find()->select([
                'updatedAt',
                'uuid'
            ])->indexBy('uuid')->column();

            foreach ($products as $product) {
                $updatedAt = ArrayHelper::getValue($allProductsUid, $product->getUid());
                $model = Product::findOne(['uuid' => $product->getUid()]);
                // product is modified, update data about it
                if (!$updatedAt || $updatedAt < $product->getUpdatedAt()) {
                    // get full info about product
                    $this->importProduct($model, $product->getUid(), $product);
                    unset($allProductsUid[$product->getUid()]);
                } elseif ($model) {
                    // check model images
                    if ($product->getImages()) {
                        $model = Product::findOne(['uuid' => $product->getUid()]);
                        $this->attachFiles($model, $product->getImages(), 'images', ['jpg', 'jpeg', 'png']);
                    }
                    if ($product->getDocuments()) {
                        $this->attachFiles($model, $product->getDocuments(), 'documents');
                    }
                    $model->save();
                    $this->stat['products.updated'] += 1;
                    // this product is active, don't touch them
                    unset($allProductsUid[$product->getUid()]);
                }
            }
            // set updatedAt date to hidden products
            if ($allProductsUid) {
                Product::updateAll(
                    [
                        'hidden' => Product::HIDDEN_YES,
                        'updatedAt' => new Expression('NOW()')
                    ],
                    [
                        'hidden' => Product::HIDDEN_NO,
                        'uuid' => array_keys($allProductsUid)
                    ]
                );
            }
        }
        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($this->productUidToId));

    }

    /**
     * import special products
     */
    protected function importPromos()
    {
        if ($usages = $this->component->getPromos()) {
            foreach ($usages as $dto) {
                $model = ProductPromo::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model) {
                        $model->delete();
                    }
                    continue;
                }
                if (!$model) {
                    $model = new ProductPromo([
                        'uuid' => $dto->getUid(),
                    ]);
                }
                $model->setScenario(ProductPromo::SCENARIO_IMPORT);

                $model->setAttributes([
                    'title' => $dto->getTitle(),
                    'color' => $dto->getColor(),
                    'hidden' => ProductPromo::HIDDEN_NO,
                    'position' => $dto->getPosition(),
                ]);
                // attach icon
                if ($icon = $dto->getIcon()) {
                    $this->attachFile($model, $icon, 'icon', ['jpg', 'jpeg', 'png', 'gif']);
                }
                $productUidList = [];
                foreach ($dto->getProducts() as $productUid) {
                    if (!Product::find()->where([
                        'uuid' => $productUid,
                    ])->exists()) {
                        if ($this->importProduct(null, $productUid)) {
                            array_push($productUidList, $productUid);
                        };
                    } else {
                        array_push($productUidList, $productUid);
                    };
                }
                $model->productId = Product::find()->select(['id'])
                    ->where(['uuid' => $productUidList])
                    ->column();

                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }
            }
        }
        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($usages));
    }

    /**
     * import product sets
     */
    protected function importProductSets()
    {
        if ($productSets = $this->component->getProductSets()) {
            foreach ($productSets as $dto) {
                $model = ProductSet::findOne(['uuid' => $dto->getUid()]);
                if ($dto->isDelete()) {
                    if ($model) {
                        $model->delete();
                        $this->consoleLog('Delete set ' . $model->id);
                    }
                    continue;
                }
                if (!$model) {
                    $model = new ProductSet([
                        'uuid' => $dto->getUid(),
                    ]);
                }
                $model->setScenario(ProductSet::SCENARIO_IMPORT);

                $model->setAttributes([
                    'article' => $dto->getArticle(),
                    'title' => $dto->getTitle(),
                    'description' => $dto->getDescription(),
                    'hidden' => ProductSet::HIDDEN_NO,
                    'position' => $dto->getPosition(),
                    'videos' => $dto->getVideos(),
                    'category' => $dto->getCategory(),
                ]);

                if ($dto->getImages()) {
                    $this->attachFiles($model, $dto->getImages(), 'images', ['jpg', 'jpeg', 'png']);
                }
                if ($dto->getDocuments()) {
                    $this->attachFiles($model, $dto->getDocuments(), 'documents');
                }

                // link this set with products
                $productItems = $productUid = [];
                foreach ($dto->getProductItems() as $productItem) {
                    if (($id = Product::find()->select(['id'])->where([
                            'uuid' => $productItem->getProductUid(),
                        ])->scalar()) === false) {
                        if ($this->importProduct(null, $productItem->getProductUid())) {
                            array_push($productItems, $productItem);
                            array_push($productUid, $productItem->getProductUid());
                        };
                    } else {
                        $productItem->setId($id);
                        array_push($productItems, $productItem);
                        array_push($productUid, $productItem->getProductUid());
                    };
                }
                $model->productItems = $productItems;

                if (!$model->save()) {
                    print_r($model->getErrors());
                    exit;
                }
                $dto->setId($model->id);

                unset($model);

                $model = ProductSet::findOne($dto->getId());

                $usageId = Product::find()
                    ->select([
                        ProductUsageRel::tableName() . '.[[usageId]]',
                        new Expression('COUNT(' . ProductUsageRel::tableName() . '.[[id]]) as [[count]]'),
                    ])
                    ->joinWith('productUsageRel', false, 'INNER JOIN')
                    ->where(['uuid' => $productUid])
                    ->groupBy([ProductUsageRel::tableName() . '.[[usageId]]'])
                    ->orderBy(['[[count]]' => SORT_DESC])
                    ->limit(1)
                    ->scalar();

                if ($usageId === false) {
                    $usageId = null;
                }
                $model->setAttribute('usageId', $usageId);

                if (!$model->save(true, ['usageId'])) {
                    print_r($model->getErrors());
                    exit;
                }

                // set documents title
                if ($dto->getDocuments()) {
                    foreach ($dto->getDocuments() as $document) {
                        if ($document->getTitle()) {
                            $this->storage::updateAll(
                                ['hint' => $document->getTitle()],
                                [
                                    'attribute' => 'documents',
                                    'title' => $document->getName(),
                                ]
                            );
                        }
                    }
                }
                unset($model);
            }
        }
        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($productSets));
    }

    /**
     * @param null|Product $model - update Product model if set $model
     * @param string $uid
     * @param ProductDto|null $productDto
     *
     * @return bool|Product
     */
    protected function importProduct($model, $uid, $productDto = null)
    {
        if (!$uid) {
            return false;
        }

        // get full info about product
        $dto = $this->component->getProduct($uid);
        if (!$dto) {
            return false;
        }
        if ($productDto) {
            $dto->setCreatedAt($productDto->getCreatedAt());
            $dto->setUpdatedAt($productDto->getUpdatedAt());
            $dto->setDocuments($productDto->getDocuments());
            $dto->setImages($productDto->getImages());
        }

        if ($dto->isDelete()) {
            if ($model) {
                // soft delete product, because we have it in relations to other products, sets, promos etc.
                $model->softDelete();
                $this->consoleLog(Console::ansiFormat('Delete product: ' . $model->title . ' (' . $model->id . ')',
                    [Console::FG_YELLOW]));
                $this->stat['products.deleted'] += 1;
            }

            return false;
        }

        // double check of existing product model
        if (!$model) {
            $model = Product::findOne(['uuid' => $uid]);

        }

        $brandId = ArrayHelper::getValue($this->brandsUidToId, $dto->getBrandUid());
        if (!$model) {
            $model = new Product([
                'uuid' => $dto->getUid(),
            ]);
            $this->consoleLog('Insert new product ' . $dto->getUid());
            $this->stat['products.created'] += 1;
        } else {
            $dto->setId($model->id);
            $this->consoleLog('Update product ' . $model->id);
            $this->stat['products.updated'] += 1;
        }

        $model->setScenario(Product::SCENARIO_IMPORT);
        $model->setAttributes([
            'brandId' => $brandId,
            'article' => $dto->getArticle(),
            'title' => $dto->getTitle(),
            'printableTitle' => $dto->getPrintableTitle(),
            'description' => $dto->getDescription(),
            'advantages' => $dto->getAdvantages(),
            'text' => $dto->getText(),
            'additionalParams' => $dto->getParams(),
            'videos' => $dto->getVideos(),
            'hidden' => ($dto->getActive() > 0 ? ProductSection::HIDDEN_NO : ProductSection::HIDDEN_YES),
            'createdAt' => $dto->getCreatedAt(),
            'updatedAt' => $dto->getUpdatedAt(),
        ]);

        // link this product with sections
        $sectionId = [];
        foreach ($dto->getSections() as $uid) {
            if ($sUid = ArrayHelper::getValue($this->sectionsUidToId, $uid)) {
                array_push($sectionId, $sUid);
            }
        }
        $model->sectionId = $sectionId;

        // link this product with properties
        $propertyValues = [];
        foreach ($dto->getProperties() as $propertyDto) {
            if (!isset($this->properties[$propertyDto->getCode()])) {
                $propModel = new ProductProperty([
                    'title' => $propertyDto->getTitle(),
                    'code' => $propertyDto->getCode(),
                ]);
                $propModel->save();
                $this->properties[$propertyDto->getCode()] = $propModel->id;
                unset($propModel);
            }
            $propertyDto->setId($this->properties[$propertyDto->getCode()]);
            array_push($propertyValues, $propertyDto);
        }
        $model->propertyValues = $propertyValues;

        // link this product with usages
        $usageId = [];
        foreach ($dto->getUsages() as $uid) {
            array_push($usageId, ArrayHelper::getValue($this->usagesUidToId, $uid));
        }
        $model->usageId = $usageId;

        // link this product with usages
        $clientCategoryId = [];
        foreach ($dto->getClientCategories() as $uid) {
            array_push($clientCategoryId, ArrayHelper::getValue($this->clientCategoriesUidToId, $uid));
        }
        $model->clientCategoryId = $clientCategoryId;

        if ($dto->getImages()) {
            $this->attachFiles($model, $dto->getImages(), 'images', ['jpg', 'jpeg', 'png']);
        }
        if ($dto->getDocuments()) {
            $this->attachFiles($model, $dto->getDocuments(), 'documents');
        }

        $needImportProducts = false;
        if ($dto->getRelatedProducts()) {
            $relatedProductId = [];
            foreach ($dto->getRelatedProducts() as $productUid) {
                if ($productId = ArrayHelper::getValue($this->productUidToId, $productUid)) {
                    array_push($relatedProductId, $productId);
                } else {
                    $needImportProducts = true;
                    break;
                }
            }
            if (!$needImportProducts) {
                $model->relatedProductId = $relatedProductId;
            }
        }

        if (!$model->save()) {
            print_r($model->getErrors());
            exit;
        }

        $dto->setId($model->id);
        if (!isset($this->productUidToId[$dto->getUid()])) {
            $this->productUidToId[$dto->getUid()] = $dto->getId();
        }
        if ($needImportProducts) {
            $this->relatedProducts[$model->id] = $dto->getRelatedProducts();
        }

        // set documents title
        if ($dto->getDocuments()) {
            foreach ($dto->getDocuments() as $document) {
                if ($document->getTitle()) {
                    $this->storage::updateAll(
                        ['hint' => $document->getTitle() ?: $model->title],
                        [
                            'attribute' => 'documents',
                            'title' => $document->getName(),
                        ]
                    );
                }
            }
        }

        return $model;
    }

    /**
     * import related products
     */
    protected function importRelatedProducts()
    {
        if ($this->relatedProducts) {
            foreach ($this->relatedProducts as $id => $relatedUidS) {
                $model = Product::findOne($id);
                $relatedProductId = [];
                foreach ($relatedUidS as $relatedUid) {
                    if ($productId = ArrayHelper::getValue($this->productUidToId, $relatedUid)) {
                        array_push($relatedProductId, $productId);
                    } else {
                        $this->importProduct(null, $relatedUid);
                        if ($productId = ArrayHelper::getValue($this->productUidToId, $relatedUid)) {
                            array_push($relatedProductId, $productId);
                        } else {
                            $this->productUidToId[$relatedUid] = null;
                        }
                    }
                }
                $model->relatedProductId = $relatedProductId;
                $model->setScenario(Product::SCENARIO_IMPORT);
                $model->save();
            }
        }
        $this->consoleLog(Console::ansiFormat('OK', [Console::FG_GREEN]));
        $this->consoleLog('Imported: ' . count($this->relatedProducts));
    }

    /**
     * @param ActiveRecord|ProductBrand|ProductSet|ProductPromo|ProductClientCategory $model
     * @param FileDto $file
     * @param $attribute
     * @param array|null $extensions
     *
     * @return bool
     */
    protected function attachFile(ActiveRecord $model, FileDto $file, $attribute, $extensions = null)
    {
        // remove file if deleted from import
        if ($file->isDelete()) {
            $fileModel = $this->storage::find()->where([
                'model' => get_class($model),
                'attribute' => $attribute,
                'recordId' => $model->id,
            ])->one();
            if ($fileModel) {
                $this->consoleLog(Console::ansiFormat('Delete file: ' . $fileModel->src . ' (' . $fileModel->id . ')',
                    [Console::FG_YELLOW]));
                $fileModel->delete();
                $this->stat['file.deleted'][] = $file->getUid();
                if (file_exists($this->storageBasePath . $fileModel->src)) {
                    @unlink($this->storageBasePath . $fileModel->src);
                }
            }

            return true;
        }
        if ($extensions && !in_array($file->getExtension(), $extensions)) {
            return false;
        }
        $exists = $this->storage::find()->where([
            'model' => get_class($model),
            'attribute' => $attribute,
            'recordId' => $model->id,
            'size' => $file->getSize(),
        ])->exists();
        if (!$exists) {
            $this->consoleLog('Attach new file ' . $file->getUid() . ' to model ' . get_class($model) . '(' . $model->id . ')');
            $this->stat['file.created'][] = $file->getUid();
            $model->{$attribute} = Yii::createObject([
                'class' => UploadedFile::class,
                'name' => $file->getName(),
                'type' => $file->getMimeType(),
                'tempName' => $file->getPath(),
                'size' => $file->getSize(),
                'error' => UPLOAD_ERR_OK,
            ]);
            $this->storage::updateAll([
                'hint' => $file->getTitle(),
            ], [
                'attribute' => $attribute,
                'title' => $file->getName(),
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param ActiveRecord|Product $model
     * @param FileDto[] $files
     * @param $attribute
     * @param array|null $extensions
     */
    protected function attachFiles(ActiveRecord $model, array $files, $attribute, $extensions = null)
    {
        $uploadDocuments = [];

        $obsoleteFiles = $this->storage::find()->where([
            'model' => get_class($model),
            'attribute' => $attribute,
            'recordId' => $model->id,
        ])->indexBy('title')->all();

        foreach ($files as $document) {

            $existsDocument = $obsoleteFiles[$document->getName()] ?? null;
            if ($document->isDelete()) {
                if ($existsDocument) {
                    $this->consoleLog(Console::ansiFormat('Delete file: ' . $existsDocument->src . ' (' . $existsDocument->id . ')',
                        [Console::FG_YELLOW]));
                    $existsDocument->delete();
                    unset($obsoleteFiles[$document->getName()]);
                    $this->stat['file.deleted'][] = $document->getUid();
                    if (file_exists($this->storageBasePath . $existsDocument->src)) {
                        @unlink($this->storageBasePath . $existsDocument->src);
                    }
                }

                continue;
            }

            if (!$existsDocument) {
                if ($extensions && !in_array($document->getExtension(), $extensions)) {
                    $this->stat['file.skip'][] = $document->getUid();
                    continue;
                }
                $this->consoleLog('Attach new file ' . $document->getUid() . ' to model ' . get_class($model) . '(' . $model->id . ')');
                $this->stat['file.created'][] = $document->getUid();
                array_push($uploadDocuments, Yii::createObject([
                    'class' => UploadedFile::class,
                    'name' => $document->getName(),
                    'type' => $document->getMimeType(),
                    'tempName' => $document->getPath(),
                    'size' => $document->getSize(),
                    'error' => UPLOAD_ERR_OK,
                ]));
                unset($obsoleteFiles[$document->getName()]);
            } else {
                unset($obsoleteFiles[$document->getName()]);
            }
        }

        if (count($obsoleteFiles) > 0) {
            foreach ($obsoleteFiles as $file) {
                $this->consoleLog(Console::ansiFormat('Delete file: ' . $file->src . ' (' . $file->id . ')',
                    [Console::FG_YELLOW]));
                $file->delete();
                $this->stat['file.deleted'][] = $file->title;
                if (file_exists($this->storageBasePath . $file->src)) {
                    @unlink($this->storageBasePath . $file->src);
                }
            }
        }

        if ($uploadDocuments && method_exists($model, 'set' . $attribute)) {
            call_user_func([$model, 'set' . $attribute], $uploadDocuments);
        }
    }

    /**
     * @param string $message
     */
    protected function consoleLog(string $message)
    {
        if ($this->debug) {
            fwrite(STDOUT, $message . PHP_EOL);
        }
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * @return bool
     */
    public function isLog(): bool
    {
        return $this->log;
    }

    /**
     * @param bool $log
     */
    public function setLog(bool $log): void
    {
        $this->log = $log;
    }

    /**
     * remove log file
     */
    protected function clearLog()
    {
        if (!$this->isLog()) {
            return;
        }
        if (file_exists(Yii::getAlias($this->logFilePath))) {
            @unlink(Yii::getAlias($this->logFilePath));
        }
    }

    /**
     * save statistic into log file
     */
    protected function saveLog()
    {
        if (!$this->isLog()) {
            return;
        }
        $fh = fopen(Yii::getAlias($this->logFilePath), 'wb');
        fwrite($fh, serialize($this->stat));
        fclose($fh);
    }

    /**
     * @return array
     */
    public function getLogDetails(): array
    {
        if (file_exists(Yii::getAlias($this->logFilePath))) {
            return unserialize(file_get_contents(Yii::getAlias($this->logFilePath)));
        }
        return [];
    }
}