<?php

use yii\db\Schema;
use yii\db\Migration;

class m150921_111119_create_mail_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('mails', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING,
            'phone' => Schema::TYPE_STRING,
            'text' => Schema::TYPE_STRING,


        ]);
    }

    public function safeDown()
    {
        echo "m150921_111119_create_mail_table cannot be reverted.\n";

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
