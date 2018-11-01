<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 31.01.18
 * Time: 12:52
 */

namespace app\modules\product\behaviors;

use app\modules\product\dto\PropertyDto;
use app\modules\product\models\Product;
use app\modules\product\models\ProductPropertyValue;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ProductPropertyBehavior
 *
 * @package app\modules\product\behaviors
 */
class ProductPropertyBehavior extends Behavior
{
    /**
     * @var string
     */
    public $propertiesAttribute = 'properties';

    /**
     * @var string
     */
    public $propertiesValuesAttribute = 'productPropertyValues';

    /**
     * Events list
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'validateConvertProperties',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveProperties',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveProperties',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteProperties',
        ];
    }

    /**
     * converts simple array [1=>'some'] to PropertyDto
     */
    public function validateConvertProperties()
    {
        /**
         * @var $primaryModel Product
         */
        $primaryModel = $this->owner;
        if (is_array($primaryModel->propertyValues) &&
            !current($primaryModel->propertyValues) instanceOf PropertyDto) {
            $propertyValues = [];
            foreach ($primaryModel->propertyValues as $propertyId => $value) {
                foreach ($primaryModel->properties as $property) {
                    if ($property->id == $propertyId) {
                        $propertyValues[$property->code] = new PropertyDto([
                            'id' => $propertyId,
                            'value' => $value,
                        ]);
                        break;
                    }
                }
            }
            $primaryModel->propertyValues = $propertyValues;
        }
    }

    public function saveProperties()
    {
        /**
         * @var $primaryModel Product
         */
        $primaryModel = $this->owner;
        $transaction = $primaryModel->getDb()->beginTransaction();
        $removeObsoleteValues = ArrayHelper::getColumn($primaryModel->productPropertyValues, 'propertyId');
        if ($primaryModel->propertyValues) {
            foreach ($primaryModel->propertyValues as $property) {
                if (!in_array($property->getId(), $removeObsoleteValues)) {
                    (new ProductPropertyValue([
                        'propertyId' => $property->getId(),
                        'productId' => $primaryModel->id,
                        'value' => $property->getValue(),
                        'unit' => $property->getUnit(),
                    ]))->save();
                } else {
                    ProductPropertyValue::updateAll([
                        'value' => $property->getValue(),
                        'unit' => $property->getUnit(),
                    ], [
                        'propertyId' => $property->getId(),
                        'productId' => $primaryModel->id,
                    ]);
                    ArrayHelper::remove($removeObsoleteValues,
                        array_search($property->getId(), $removeObsoleteValues)
                    );
                }
            }
        }

        // cleanup
        if (!empty($removeObsoleteValues)) {
            ProductPropertyValue::deleteAll([
                'propertyId' => $removeObsoleteValues,
                'productId' => $primaryModel->id,
            ]);
        }
        $transaction->commit();
    }

    /**
     *
     */
    public function deleteProperties()
    {
        /**
         * @var $primaryModel Product
         */
        $primaryModel = $this->owner;
        ProductPropertyValue::deleteAll([
            'productId' => $primaryModel->id,
        ]);
    }

    /**
     * @return PropertyDto[]
     */
    public function getPropertyValues()
    {
        /**
         * @var $primaryModel Product
         */
        $primaryModel = $this->owner;
        if (!$primaryModel->propertyValues &&
            $primaryModel->productPropertyValues &&
            $primaryModel->properties) {
            $productPropertyValues = ArrayHelper::map($primaryModel->productPropertyValues, 'propertyId',
                function ($row) {
                    return $row;
                });
            $propertyValues = [];
            foreach ($primaryModel->properties as $property) {
                $propertyValues[$property->code] = new PropertyDto([
                    'id' => $property->id,
                    'code' => $property->code,
                    'title' => $property->title,
                    'value' => isset($productPropertyValues[$property->id]) ?
                        $productPropertyValues[$property->id]['value'] : '',
                    'unit' => isset($productPropertyValues[$property->id]) ?
                        $productPropertyValues[$property->id]['unit'] : '',
                ]);
            }
            $primaryModel->propertyValues = $propertyValues;
        }

        return $primaryModel->propertyValues;
    }

    /**
     * @param string $code
     *
     * @return string|null
     */
    public function getPropertyValue(string $code)
    {
        return ArrayHelper::getValue($this->getPropertyValues(), [$code, 'value']);
    }

    /**
     * @param string $code
     *
     * @return string|null
     */
    public function getPropertyUnit(string $code)
    {
        return ArrayHelper::getValue($this->getPropertyValues(), [$code, 'unit']);
    }
}