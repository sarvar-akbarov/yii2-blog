<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner_item}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%banner}}`
 */
class m210531_133650_create_banner_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner_item}}', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer()->comment("Рекламный баннер"),// Рекламный баннер
            'type' => $this->integer()->comment("Тип"),// Тип 1-Изображение, 2 -Код
            'code' => $this->text()->comment("Код"),
            'img' => $this->string(255)->comment("Картинка"),
            'url' => $this->string(255)->comment("Ссылка"),
            'show_start' => $this->datetime()->comment("Дата начала"),
            'show_finish' => $this->datetime()->comment("Дата окончание"),
            'show_limit' => $this->integer()->comment("Количество показа"),
            'status' => $this->integer()->comment(""),// активно - 1, не активно - 0
            'target_blank' => $this->boolean()->comment("Таргет"),// Таргет или нет 0 - Нет, 1 - Да
            'sorting_number' => $this->integer()->comment("Порядковый номер"),
            'time' => $this->integer()->comment("Время"),// Время har bir slayd necha sekund aylanishini aniqlaydi
            //----------------------tarjima uchun maydonlar------------------------
            // title varchar(255) // Наименование рекламы
            // description text // Текст 
            // alt varchar(255) // Алт
        ]);

        // creates index for column `banner_id`
        $this->createIndex(
            '{{%idx-banner_item-banner_id}}',
            '{{%banner_item}}',
            'banner_id'
        );

        // add foreign key for table `{{%banner}}`
        $this->addForeignKey(
            '{{%fk-banner_item-banner_id}}',
            '{{%banner_item}}',
            'banner_id',
            '{{%banner}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%banner}}`
        $this->dropForeignKey(
            '{{%fk-banner_item-banner_id}}',
            '{{%banner_item}}'
        );

        // drops index for column `banner_id`
        $this->dropIndex(
            '{{%idx-banner_item-banner_id}}',
            '{{%banner_item}}'
        );

        $this->dropTable('{{%banner_item}}');
    }
}
