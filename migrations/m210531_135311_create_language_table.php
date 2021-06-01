<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m210531_135311_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(255)->comment("Код языка"),// Код языка kode en, ru, uz
            'local' => $this->string(255)->comment("Местное название"),
            'name' => $this->string(255)->comment("Наименование"),
            'image' => $this->string(255)->comment("Фотография"),
            'default' => $this->integer()->comment("поумолчанию"),
            'status' => $this->integer()->comment("Статус"),// Статус 1- актив, 2 -не активно
        ]);
        
        $this->insert('{{%language}}', [
            'code' => 'ru',
            'local' => 'Русский',
            'name' => 'Russian',
            'default' => 1,
            'status' => 1,
        ]);

        $this->insert('{{%language}}', [
            'code' => 'en',
            'local' => 'English',
            'name' => 'English',
            'default' => 0,
            'status' => 1,
        ]);

        $this->insert('{{%language}}', [
            'code' => 'uz',
            'local' => 'O\'zbek',
            'name' => 'Uzbek',
            'default' => 0,
            'status' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
