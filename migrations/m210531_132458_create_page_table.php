<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m210531_132458_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'keyword' => $this->string(255)->comment("Наименование"),
            'status' => $this->integer()->comment("Статус"),// Статус 1 - актив, 2 - не активно
            // //----------------------tarjima uchun maydonlar------------------------
            // title varchar(255) // Заголовок 
            // description text // Описание
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
            // view_share_sitename varchar(255) // Название сайта (поделиться в соц. се
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
