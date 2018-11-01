<?php

use app\modules\product\models\ProductSet;
use yii\db\Migration;

/**
 * Class m180625_100157_set_article
 */
class m180625_100157_set_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(ProductSet::tableName(), 'article',
            $this->string(125)->notNull()->defaultValue('')->after('uuid')
        );
        $this->createIndex('article', ProductSet::tableName(), ['article']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(ProductSet::tableName(), 'article');
    }
}
