<?php

use yii\db\Schema;
use yii\db\Migration;

class m150226_055724_user_module_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_INTEGER,
            'username' => Schema::TYPE_STRING . '(30) NOT NULL',
            'email' => Schema::TYPE_STRING . '(100) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(100) NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
