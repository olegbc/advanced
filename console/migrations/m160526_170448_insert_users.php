<?php

use yii\db\Migration;

class m160526_170448_insert_users extends Migration
{

    public function Up()
    {
        $password = '123456';
        $password_hash = Yii::$app->security->generatePasswordHash($password);
        /**
         * password_hash the same for all users to reduce time consumption, just for test case; all users get status registered(10),
         * sex 'male', location 'Kiev', last_signin and registration_date to current time
         */
        for($i=1;$i<=1001;$i++) {
            $this->insert('user', array('role' => 10, 'auth_key' => Yii::$app->security->generateRandomString(), 'password_hash' => $password_hash, 'password_reset_token' => NULL, 'email' => 'user' . $i . '@gmail.com', 'status' => 10, 'name' => 'user' . $i, 'sex' => 'male', 'location' => 'Kiev','last_signin' => time(),'registration_date' => time(), 'created_at' => time(), 'updated_at' => time()));
        }
    }

    public function Down()
    {
        for($i=1;$i<=1001;$i++) {
            $this->delete('user', ['email' => 'user' . $i . '@gmail.com']);
        }
    }

}
