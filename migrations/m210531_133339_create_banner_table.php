<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m210531_133339_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'keyword' => $this->string(255)->comment("Ключ"),
            'title' => $this->string(255)->comment(" Наименование рекламы"),
            'status' => $this->integer()->comment("Статус"), // активно - 1, не активно - 0
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }
}
