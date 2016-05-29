<?php

use yii\db\Migration;

class m160528_065136_change_sex_columt_structure extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('user', 'sex');
        $this->addColumn('user', 'sex', $this->string(10)->after('name'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'sex');
        $this->addColumn('user', 'sex', $this->integer(1)->defaultValue(1)->after('name'));
    }
}
