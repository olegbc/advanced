<?php

use yii\db\Migration;

/**
 * Handles adding registration_date to table `user`.
 */
class m160527_145859_add_registration_date_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'registration_date', $this->integer(11)->notNull()->after('sent_date'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'registration_date');
    }
}
