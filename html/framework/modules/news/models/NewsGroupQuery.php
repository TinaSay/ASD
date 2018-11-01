<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the ActiveQuery class for [[NewsGroup]].
 *
 * @see NewsGroup
 */
class NewsGroupQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return NewsGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsGroup|array|null
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

        return $this->andWhere([NewsGroup::tableName() . '.[[language]]' => $language]);
    }
}
