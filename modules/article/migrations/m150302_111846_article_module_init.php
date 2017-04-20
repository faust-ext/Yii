<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_111846_article_module_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%articles_categories}}', [
            'id' => Schema::TYPE_PK,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_INTEGER,
            'parent_id' => Schema::TYPE_INTEGER,
            'alias' => Schema::TYPE_STRING . '(30) NOT NULL',
            'image' => Schema::TYPE_STRING
        ]);

        $this->addForeignKey('articles_categories_parent_id', '{{%articles_categories}}', 'parent_id', '{{%articles_categories}}', 'id');

        $this->createTable('{{%articles_categories_langs}}', [
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT
        ]);

        $this->addPrimaryKey('articles_categories_langs_pk', '{{%articles_categories_langs}}', ['category_id', 'lang_id']);

        $this->addForeignKey('articles_categories_langs_category_id', '{{%articles_categories_langs}}', 'category_id', '{{%articles_categories}}', 'id');
        $this->addForeignKey('articles_categories_langs_lang_id', '{{%articles_categories_langs}}', 'lang_id', '{{%langs}}', 'id');

        $this->createTable('{{%articles}}', [
            'id' => Schema::TYPE_PK,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_INTEGER,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'published_at' => Schema::TYPE_INTEGER,
            'published_until' => Schema::TYPE_INTEGER,
            'preview_image' => Schema::TYPE_STRING
        ]);

        $this->addForeignKey('articles_category_id', '{{%articles}}', 'category_id', '{{%articles_categories}}', 'id');
        $this->addForeignKey('articles_author_id', '{{%articles}}', 'author_id', '{{%users}}', 'id');

        $this->createTable('{{%articles_langs}}', [
            'article_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'lang_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'intro_text' => Schema::TYPE_TEXT . ' NOT NULL',
            'full_text' => Schema::TYPE_TEXT . ' NOT NULL',
        ]);

        $this->addPrimaryKey('articles_langs_pk', '{{%articles_langs}}', ['article_id', 'lang_id']);

        $this->addForeignKey('articles_langs_article_id', '{{%articles_langs}}', 'article_id', '{{%articles}}', 'id');
        $this->addForeignKey('articles_langs_lang_id', '{{%articles_langs}}', 'lang_id', '{{%langs}}', 'id');
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%articles_langs}}');
        $this->dropTable('{{%articles}}');
        $this->dropTable('{{%articles_categories_langs}}');
        $this->dropTable('{{%articles_categories}}');
    }
}
