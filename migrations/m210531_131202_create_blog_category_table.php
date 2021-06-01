<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog_category}}`
 */
class m210531_131202_create_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_category}}', [
            'id' => $this->primaryKey(),
            'numlevel' => $this->integer()->comment("Уровень"),
            'icon_b' => $this->string(255)->comment("Иконка (большая)"),
            'icon_s' => $this->string(255)->comment("Иконка (малая)"),
            'keyword' => $this->text()->comment(""),
            'status' => $this->boolean()->comment("Статус"),// Статус 1 => Активно , 0 => Не активно
            'parent_id' => $this->integer()->comment("Парент категория"),
            // //----------------------tarjima uchun maydonlar------------------------
            // title varchar(255) // Заголовок)
            // //--------------------SEO Поиск в категории------------
            // mtitle varchar(255) // Заголовок (title)
            // mkeywords text // Ключевые слова (meta keywords)
            // mdescription text // Описание (meta description)
            // titleh1 varchar(255) // Заголовок H1 
            // seotext text // SEO текст
            // breadcrumb varchar(255) // Хлебная крошка
            // //------------------SEO Просмотр объявления------------
            // view_mtitle varchar(255) // Заголовок (title )
            // view_mkeywords text // Ключевые слова (meta keywords)
            // view_mdescription text // Описание (meta description)
            // view_share_title varchar(255) //Заголовок (поделиться в соц. сетях)
            // view_share_description text // Описание (поделиться в соц. сетях)
            // view_share_sitename varchar(255) // Название сайта (поделиться в соц. 
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-blog_category-parent_id}}',
            '{{%blog_category}}',
            'parent_id'
        );

        // add foreign key for table `{{%blog_category}}`
        $this->addForeignKey(
            '{{%fk-blog_category-parent_id}}',
            '{{%blog_category}}',
            'parent_id',
            '{{%blog_category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%blog_category}}`
        $this->dropForeignKey(
            '{{%fk-blog_category-parent_id}}',
            '{{%blog_category}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-blog_category-parent_id}}',
            '{{%blog_category}}'
        );

        $this->dropTable('{{%blog_category}}');
    }
}
