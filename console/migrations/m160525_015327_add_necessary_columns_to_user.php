<?php

use yii\db\Migration;

/**
 * Handles:
 * adding role to table `user`,
 * adding role to table `user`,
 * adding account_registration_token to table `user`,
 * adding name to table `user`,
 * adding sex to table `user`,
 * adding location to table `user`,
 * adding last_signin to table `user`,
 * adding sent_date to table `user`,
 * adding registration_date to table `user`,
 * adding inviter to table `user`,
 */
class m160525_015327_add_necessary_columns_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
        $this->addColumn('user', 'role', $this->integer(2)->notNUll()->defaultValue(10)->after('email'));
        $this->addColumn('user', 'account_registration_token', $this->string()->defaultValue(Null)->after('password_reset_token'));
        $this->addColumn('user', 'name', $this->string(255)->defaultValue(Null)->after('status'));
        $this->addColumn('user', 'sex', $this->string(10)->after('name'));
        $this->addColumn('user', 'location', $this->string(255)->defaultValue(Null)->after('sex'));
        $this->addColumn('user', 'last_signin', $this->integer(11)->after('location'));
        $this->addColumn('user', 'sent_date', $this->integer(11)->notNull()->after('last_signin'));
        $this->addColumn('user', 'inviter', $this->string(255)->after('sent_date'));
        $this->addColumn('user', 'registration_date', $this->integer(11)->notNull()->after('inviter'));
    }

    /**
     * @inheritdoc
     */
    public function Down()
    {
        $this->dropColumn('user', 'role');
        $this->dropColumn('user', 'account_registration_token');
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'sex');
        $this->dropColumn('user', 'location');
        $this->dropColumn('user', 'last_signin');
        $this->dropColumn('user', 'sent_date');
        $this->dropColumn('user', 'inviter');
        $this->dropColumn('user', 'registration_date');
    }
}
