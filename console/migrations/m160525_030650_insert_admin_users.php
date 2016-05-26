<?php

use yii\db\Migration;
use common\models\User;

class m160525_030650_insert_admin_users extends Migration
{

    public function safeUp()
    {
        $password = '123456';
        $password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->insert('user', array('role' => 20, 'auth_key' => Yii::$app->security->generateRandomString(), 'password_hash' => Yii::$app->security->generatePasswordHash($password), 'password_reset_token' => NULL, 'email' => 'admin@gmail.com', 'status' => 10, 'created_at' => time(), 'updated_at' => time()));
        // password_hash the same for all users to reduce time consumption, just for test case; all users set to status activated(10)
        for($i=1;$i<=1000;$i++) {
            $this->insert('user', array('role' => 10, 'auth_key' => Yii::$app->security->generateRandomString(), 'password_hash' => $password_hash, 'password_reset_token' => NULL, 'email' => 'user' . $i . '@gmail.com', 'status' => 10, 'created_at' => time(), 'updated_at' => time()));
        }
    }

    public function safeDown()
    {
        for($i=1;$i<=1000;$i++) {
            $this->delete('user', ['email' => 'user' . $i . '@gmail.com']);
        }
        $this->delete('user', ['email' => 'admin@gmail.com']);
    }

}
