<?php

use yii\db\Schema;
use yii\db\Migration;

class m150819_173031_paid extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE galaxysss_4.cap_stock_kurs ADD delta FLOAT NULL;');
    }

    public function down()
    {
        echo "m150819_173031_paid cannot be reverted.\n";

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
