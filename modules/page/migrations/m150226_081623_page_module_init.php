<?php

use yii\db\Schema;
use yii\db\Migration;

class m150226_081623_page_module_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%pages}}', [
            'id'         => Schema::TYPE_PK,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_INTEGER,
            'alias'      => Schema::TYPE_STRING . '(30) NOT NULL',
        ]);

        $this->createTable('{{%pages_langs}}', [
            'page_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title'   => Schema::TYPE_STRING . '(255)',
            'text'    => Schema::TYPE_TEXT,
            'PRIMARY KEY (page_id, lang_id)',
            'FOREIGN KEY (page_id) REFERENCES pages(id)',
            'FOREIGN KEY (lang_id) REFERENCES langs(id)',
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%pages_langs}}');
        $this->dropTable('{{%pages}}');
    }
}
