<?php

use yii\db\Migration;

/**
 * Handles adding name_sex_location to table `user`.
 */
class m160526_164935_add_name_sex_location_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'name', $this->string(255)->defaultValue(Null)->after('status'));
        $this->addColumn('user', 'sex', $this->integer(1)->defaultValue(1)->after('name'));
        $this->addColumn('user', 'location', $this->string(255)->defaultValue(Null)->after('sex'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'sex');
        $this->dropColumn('user', 'location');
    }
}
