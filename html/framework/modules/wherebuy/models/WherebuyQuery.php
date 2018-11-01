<?php

namespace app\modules\wherebuy\models;

use yii;

/**
 * This is the ActiveQuery class for [[Wherebuy]].
 *
 * @see Wherebuy
 */
class WherebuyQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Wherebuy[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Wherebuy|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $language
     *
     * @return $this
     */
    public function language($language = null)
    {
        if ($language === null) {
            $language = Yii::$app->language;
        }

        return $this->andWhere([Wherebuy::tableName() . '.[[language]]' => $language]);
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere([Wherebuy::tableName() . '.[[hidden]]' => Wherebuy::HIDDEN_NO]);
    }

    /**
     * @return $this
     */
    public function showInProduct()
    {
        return $this->andWhere([Wherebuy::tableName() . '.[[showInProduct]]' => Wherebuy::SHOW_IN_PRODUCT_YES]);
    }
}
