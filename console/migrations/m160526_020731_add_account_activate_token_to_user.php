<?php

use yii\db\Migration;

/**
 * Handles adding account_activate_token to table `user`.
 */
class m160526_020731_add_account_activate_token_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'account_activation_token', $this->string()->defaultValue(Null)->after('password_reset_token'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'account_activation_token');
    }
}
