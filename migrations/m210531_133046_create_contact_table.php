<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210531_133046_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->comment("Тип"),// Тип 1-Ошибка на сайте, 2-Технический вопрос, 3-Предложение, 4-Другие вопросы
            'user_id' => $this->integer()->comment("Пользователь"),
            'user_ip' => $this->string(255)->comment("Ip"),
            'name' => $this->string(255)->comment("ФИО"),
            'email' => $this->string(255)->comment("E-mail"),
            'phone' => $this->string(255)->comment("Телефон номер"),
            'message' => $this->text()->comment("Сообщение"),
            'user_agent' => $this->text()->comment("Браузер пользователья"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'viewed' => $this->boolean()->comment("Статус"),// Статус 0-Нет, 1-Д
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-contact-user_id}}',
            '{{%contact}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-contact-user_id}}',
            '{{%contact}}'
        );

        $this->dropTable('{{%contact}}');
    }
}
