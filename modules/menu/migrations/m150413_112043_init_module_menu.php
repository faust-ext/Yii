<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_112043_init_module_menu extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%menu_menus}}', [
            'id'         => 'pk',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'title'      => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->createTable('{{%menu_items}}', [
            'id'         => 'pk',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'menu_id'    => Schema::TYPE_INTEGER . ' NOT NULL',
            'sort'       => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_id'  => Schema::TYPE_INTEGER,
            'url'        => Schema::TYPE_TEXT . ' NOT NULL',
        ]);

        $this->addForeignKey('menu_items_menu_id', '{{%menu_items}}', 'menu_id', '{{%menu_menus}}', 'id');

        $this->createTable('{{%menu_items_langs}}', [
            'item_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title'   => Schema::TYPE_STRING,
        ]);

        $this->addPrimaryKey('menu_items_langs_pk', '{{%menu_items_langs}}', ['item_id', 'lang_id']);

        $this->addForeignKey('menu_items_langs_item_id', '{{%menu_items_langs}}', 'item_id', '{{%menu_items}}', 'id');
        $this->addForeignKey('menu_items_langs_lang_id', '{{%menu_items_langs}}', 'lang_id', '{{%langs}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('menu_items_langs');
        $this->dropTable('menu_items');
        $this->dropTable('menu_menus');
    }
}
