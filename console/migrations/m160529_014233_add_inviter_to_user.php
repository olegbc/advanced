<?php

use yii\db\Migration;

/**
 * Handles adding inviter to table `user`.
 */
class m160529_014233_add_inviter_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'inviter', $this->string(255)->after('registration_date'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'inviter');
    }
}
