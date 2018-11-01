<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 25.09.17
 * Time: 16:31
 */

namespace app\modules\product\controllers\console;

use app\modules\product\models\Product;
use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductClientCategory;
use app\modules\product\models\ProductClientCategoryRel;
use app\modules\product\models\ProductPromo;
use app\modules\product\models\ProductPromoRel;
use app\modules\product\models\ProductPropertyValue;
use app\modules\product\models\ProductRel;
use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductSectionRel;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductSetRel;
use app\modules\product\models\ProductUsage;
use app\modules\product\models\ProductUsageRel;
use app\modules\product\Module;
use app\modules\product\services\ImportService;
use krok\storage\models\Storage;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class ImportController extends Controller
{
    /**
     * @var bool
     */
    public $debug = false;

    /**
     * @var ImportService
     */
    protected $service;

    /**
     * ImportController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param ImportService $service
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        ImportService $service,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function options($actionID)
    {
        return ['debug'];
    }

    /**
     * @return int
     */
    public function actionIndex()
    {
        $this->service->setDebug($this->debug);
        $this->service->setLog(true);

        $this->service->import();

        return ExitCode::OK;
    }

    public function actionClean()
    {
        $answer = Console::prompt(
            'All product data will be removed.' . PHP_EOL .
            'Are you sure (y/n)?'
        );
        if ($answer == 'y') {
            // delete files
            $files = Storage::find()->where([
                'like',
                'model',
                'Product',
            ])->all();

            foreach ($files as $file) {
                $file->delete();
            }

            fwrite(STDOUT, 'Files removed: ' . count($files) . PHP_EOL);
            unset($files);

            //delete other models
            ProductUsageRel::deleteAll();
            ProductUsage::deleteAll();
            ProductSetRel::deleteAll();
            ProductSet::deleteAll();
            ProductSectionRel::deleteAll();
            ProductSection::deleteAll();
            ProductRel::deleteAll();
            ProductPropertyValue::deleteAll();
            ProductPromoRel::deleteAll();
            ProductPromo::deleteAll();
            ProductClientCategoryRel::deleteAll();
            ProductClientCategory::deleteAll();
            ProductBrand::deleteAll();
            Product::deleteAll();
            fwrite(STDOUT, 'Product data removed.' . PHP_EOL);
        }

        return ExitCode::OK;
    }
}