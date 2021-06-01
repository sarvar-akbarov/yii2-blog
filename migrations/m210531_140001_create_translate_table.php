<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translate}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%language}}`
 */
class m210531_140001_create_translate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translate}}', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(255)->comment("Наименование таблицы"),
            'model_id' => $this->integer()->comment("ID строка"),
            'field_name' => $this->string(255)->comment("Наименование строка"),
            'field_description' => $this->string(255)->comment("Описание поля"),
            'field_value' => $this->text()->comment("Значение"),
            'language_id' => $this->integer()->comment(""),
        ]);

        // creates index for column `language_id`
        $this->createIndex(
            '{{%idx-translate-language_id}}',
            '{{%translate}}',
            'language_id'
        );

        // add foreign key for table `{{%language}}`
        $this->addForeignKey(
            '{{%fk-translate-language_id}}',
            '{{%translate}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%language}}`
        $this->dropForeignKey(
            '{{%fk-translate-language_id}}',
            '{{%translate}}'
        );

        // drops index for column `language_id`
        $this->dropIndex(
            '{{%idx-translate-language_id}}',
            '{{%translate}}'
        );

        $this->dropTable('{{%translate}}');
    }
}
