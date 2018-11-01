<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cmf2_subscribe`.
 */
class m171118_072824_subscribe extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;
        $this->createTable('{{%subscribe}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(100),
            'country' => $this->string(100),
            'city' => $this->string(),
            'createdAt' => $this->datetime(),
            'ip' => $this->string(50),
        ], $options);

        /**
         * Пока не будем добавлять тестовые данные
         * ***************************************
         *   for ($i = 1; $i <= 4; $i++) {
         *      $email = 'test' . $i . '@gmailtest.com';
         *       $city = 'Город' . $i;
         *       $country = 'Страна' . $i;
         *       Yii::$app->db->createCommand()->insert('{{%subscribe}}', [
         *           'email' => $email,
         *           'country' => $country,
         *           'city' => $city,
         *           'createdAt' => new \yii\db\Expression('NOW()'),
         *           'ip' => '127.0.0.1',
         *       ])->execute();
         *   }
         */
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%subscribe}}');
    }
}
