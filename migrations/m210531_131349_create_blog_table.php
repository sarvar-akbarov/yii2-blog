<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog_category}}`
 * - `{{%user}}`
 */
class m210531_131349_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->comment("Категория"),
            'user_id' => $this->integer()->comment("Создатель"),
            'date_cr' => $this->datetime()->comment("Дата создании"),
            'slug' => $this->string(255)->comment("Слуг"),
            'image' => $this->string(255)->comment("Картинка"),
            'status' => $this->integer()->comment("Статус"),// Статус 1 - Активнов 2 - Не активно
            'view_count' => $this->integer()->comment(" Количество просмотров"),
            // //----------------------tarjima uchun maydonlar------------------------
            // title varchar(255) // Наименование
            // short_text text // Короткое Описание
            // text text // Текст
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
            // view_share_sitename varchar(255) // Название сайта (поделиться в соц. сетях)
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-blog-category_id}}',
            '{{%blog}}',
            'category_id'
        );

        // add foreign key for table `{{%blog_category}}`
        $this->addForeignKey(
            '{{%fk-blog-category_id}}',
            '{{%blog}}',
            'category_id',
            '{{%blog_category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-blog-user_id}}',
            '{{%blog}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-blog-user_id}}',
            '{{%blog}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-blog-category_id}}',
            '{{%blog}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-blog-category_id}}',
            '{{%blog}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-blog-user_id}}',
            '{{%blog}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-blog-user_id}}',
            '{{%blog}}'
        );

        $this->dropTable('{{%blog}}');
    }
}
