<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translations}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%languages}}`
 */
class m210514_053332_create_translations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translations}}', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(255),
            'language_code' => $this->integer(),
            'model_id' => $this->integer(),
            'field_name' => $this->string(255),
            'field_value' => $this->text(),
        ]);

        // creates index for column `language_code`
        $this->createIndex(
            '{{%idx-translations-language_code}}',
            '{{%translations}}',
            'language_code'
        );

        // add foreign key for table `{{%languages}}`
        $this->addForeignKey(
            '{{%fk-translations-language_code}}',
            '{{%translations}}',
            'language_code',
            '{{%languages}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%languages}}`
        $this->dropForeignKey(
            '{{%fk-translations-language_code}}',
            '{{%translations}}'
        );

        // drops index for column `language_code`
        $this->dropIndex(
            '{{%idx-translations-language_code}}',
            '{{%translations}}'
        );

        $this->dropTable('{{%translations}}');
    }
}
