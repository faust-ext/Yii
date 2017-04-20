<?php

use yii\db\Schema;
use yii\db\Migration;

class m130302_081837_lang_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%langs}}', [
            'id'     => Schema::TYPE_PK,
            'title'  => Schema::TYPE_STRING . '(30)',
            'locale' => Schema::TYPE_STRING . '(5)',
            'prefix' => Schema::TYPE_STRING . '(2)',
        ]);

        $this->insert('{{%langs}}', ['title' => 'Русский', 'locale' => 'ru-RU', 'prefix' => 'ru']);

    }

    public function down()
    {
        $this->dropTable('{{%langs}}');
    }

}
