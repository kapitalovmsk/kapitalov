<?php

use yii\db\Schema;
use yii\db\Migration;

class m150905_141710_referal extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_4.cap_registration CHANGE referal_link referal_code VARCHAR(20);');
    }

    public function down()
    {
        echo "m150905_141710_referal cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
