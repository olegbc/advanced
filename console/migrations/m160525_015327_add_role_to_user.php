<?php

use yii\db\Migration;

/**
 * Handles adding role to table `user`.
 */
class m160525_015327_add_role_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->integer(2)->notNUll()->defaultValue(10)->after('username'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }
}
