<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_123447_feedback_module_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%feedbacks}}', [
            'id'             => Schema::TYPE_PK,
            'created_at'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'     => Schema::TYPE_INTEGER,
            'answered_at'    => Schema::TYPE_INTEGER,
            'status'         => Schema::TYPE_INTEGER,
            'lang_id'        => Schema::TYPE_INTEGER,
            'name'           => Schema::TYPE_STRING . '(255)',
            'email'          => Schema::TYPE_STRING . '(100)',
            'answerer_id'    => Schema::TYPE_INTEGER,
            'question'       => Schema::TYPE_TEXT,
            'answer'         => Schema::TYPE_TEXT,
        ]);

        $this->addForeignKey('feedbacks_lang_id', '{{%feedbacks}}', 'lang_id', '{{%langs}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%feedbacks}}');
    }

}
