<?php

namespace app\modules\advice\models;

use Yii;

/**
 * This is the ActiveQuery class for [[advice]].
 *
 * @see advice
 */
class AdviceQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return advice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return advice|array|null
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

        return $this->andWhere([Advice::tableName() . '.[[language]]' => $language]);
    }
}
