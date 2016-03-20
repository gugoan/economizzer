<?php

use yii\db\Migration;

class m160320_200425_initial extends Migration
{
    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/m160320_200425_initial.sql')); 
    }

    public function down()
    {
        echo "m160320_200425_initial cannot be reverted.\n";
        return false;
    }

}
