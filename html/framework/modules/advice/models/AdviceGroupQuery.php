<?php

namespace app\modules\advice\models;

use Yii;

/**
 * This is the ActiveQuery class for [[adviceGroup]].
 *
 * @see adviceGroup
 */
class AdviceGroupQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return AdviceGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return adviceGroup|array|null
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

        return $this->andWhere([AdviceGroup::tableName() . '.[[language]]' => $language]);
    }
}
