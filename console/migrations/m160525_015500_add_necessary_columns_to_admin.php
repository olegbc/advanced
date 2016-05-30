<?php

use yii\db\Migration;

/**
 * Handles:
 * adding role to table `admin`,
 */
class m160525_015500_add_necessary_columns_to_admin extends Migration
{
    /**
     * @inheritdoc
     */
    public function Up()
    {
        $this->addColumn('admin', 'role', $this->integer(2)->after('email'));
    }

    /**
     * @inheritdoc
     */
    public function Down()
    {
        $this->dropColumn('admin', 'role');
    }
}
