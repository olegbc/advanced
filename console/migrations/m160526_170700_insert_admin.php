<?php

use yii\db\Migration;

class m160526_170700_insert_admin extends Migration
{

    public function Up()
    {
        $password = '123456';
        $password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->insert('admin', array('role' => 20, 'auth_key' => Yii::$app->security->generateRandomString(), 'password_hash' => Yii::$app->security->generatePasswordHash($password), 'email' => 'admin@gmail.com', 'created_at' => time(), 'updated_at' => time()));
    }

    public function Down()
    {
        $this->delete('admin', ['email' => 'admin@gmail.com']);
    }

}
