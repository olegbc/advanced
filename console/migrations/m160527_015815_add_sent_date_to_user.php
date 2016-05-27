<?php

use yii\db\Migration;

/**
 * Handles adding send_date to table `user`.
 */
class m160527_015815_add_sent_date_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'sent_date', $this->integer(11)->notNull()->after('location'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'sent_date');
    }
}
