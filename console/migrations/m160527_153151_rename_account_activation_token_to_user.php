<?php

use yii\db\Migration;

class m160527_153151_rename_account_activation_token_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameColumn('user', 'account_activation_token', 'account_registration_token');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameColumn('user', 'account_registration_token', 'account_activation_token');
    }
}
