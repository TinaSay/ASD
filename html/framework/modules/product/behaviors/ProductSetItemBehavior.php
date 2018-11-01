<?php

namespace app\modules\product\behaviors;

use app\modules\product\dto\ProductSetItemDto;
use app\modules\product\models\Product;
use app\modules\product\models\ProductSet;
use app\modules\product\models\ProductSetRel;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ProductSetItemBehavior
 *
 * @package app\modules\product\behaviors
 */
class ProductSetItemBehavior extends Behavior
{
    /**
     * Events list
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'validateConvert',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveProductItems',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveProductItems',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteProductItems',
        ];
    }

    /**
     * converts simple array [1=>'some'] to ProductSetItemDto
     */
    public function validateConvert()
    {
        /**
         * @var $primaryModel ProductSet
         */
        $primaryModel = $this->owner;
        if (is_array($primaryModel->productItems) &&
            !current($primaryModel->productItems) instanceOf ProductSetItemDto) {
            $productItems = [];
            foreach ($primaryModel->productItems as $productItemId => $quantity) {
                foreach ($primaryModel->products as $productItem) {
                    if ($productItem->id == $productItemId) {
                        $productItems[$productItem->id] = new ProductSetItemDto([
                            'id' => $productItemId,
                            'setId' => $primaryModel->id,
                            'productUid' => $productItem->uuid,
                            'quantity' => $quantity,
                        ]);
                        break;
                    }
                }
            }
            $primaryModel->productItems = $productItems;
        }
    }

    public function saveProductItems()
    {
        /**
         * @var $primaryModel ProductSet
         */
        $primaryModel = $this->owner;
        $transaction = $primaryModel->getDb()->beginTransaction();
        $removeObsoleteValues = ArrayHelper::getColumn($primaryModel->productSetRel, 'productId');
        if ($primaryModel->productItems) {
            foreach ($primaryModel->productItems as $productItem) {
                $productId = Product::find()->select(['id'])->where([
                    'uuid' => $productItem->getProductUid(),
                ])->scalar();
                if (!$productId) {
                    continue;
                }
                if (!in_array($productItem->getId(), $removeObsoleteValues)) {
                    (new ProductSetRel([
                        'setId' => $primaryModel->id,
                        'productId' => $productId,
                        'quantity' => $productItem->getQuantity(),
                    ]))->save();
                } else {
                    ProductSetRel::updateAll([
                        'quantity' => $productItem->getQuantity(),
                    ], [
                        'setId' => $primaryModel->id,
                        'productId' => $primaryModel->id,
                    ]);
                    ArrayHelper::remove($removeObsoleteValues,
                        array_search($productItem->getId(), $removeObsoleteValues)
                    );
                }
            }
        }

        // cleanup
        if (!empty($removeObsoleteValues)) {
            ProductSetRel::deleteAll([
                'setId' => $removeObsoleteValues,
                'productId' => $primaryModel->id,
            ]);
        }
        $transaction->commit();
    }

    /**
     *
     */
    public function deleteProductItems()
    {
        /**
         * @var $primaryModel ProductSet
         */
        $primaryModel = $this->owner;
        ProductSetRel::deleteAll([
            'productId' => $primaryModel->id,
        ]);
    }

}