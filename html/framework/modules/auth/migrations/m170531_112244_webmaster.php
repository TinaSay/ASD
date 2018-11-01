<?php

use yii\db\Migration;

class m170531_112244_webmaster extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%auth}}', [
            'login' => 'webmaster',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(128),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(128),
            'email' => 'webmaster@dev-vps.ru',
            'blocked' => 0,
            'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%auth}}', ['login' => 'webmaster']);
    }
}
