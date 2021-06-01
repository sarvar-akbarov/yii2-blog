<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner_statistic}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%banner}}`
 */
class m210531_135059_create_banner_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner_statistic}}', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer()->comment("Рекламный баннер"),
            'date' => $this->date()->comment("Дата"),
            'clicks' => $this->integer()->comment("Количество кликов"),
            'shows' => $this->integer()->comment("Количество просмотр"),
        ]);

        // creates index for column `banner_id`
        $this->createIndex(
            '{{%idx-banner_statistic-banner_id}}',
            '{{%banner_statistic}}',
            'banner_id'
        );

        // add foreign key for table `{{%banner}}`
        $this->addForeignKey(
            '{{%fk-banner_statistic-banner_id}}',
            '{{%banner_statistic}}',
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
            '{{%fk-banner_statistic-banner_id}}',
            '{{%banner_statistic}}'
        );

        // drops index for column `banner_id`
        $this->dropIndex(
            '{{%idx-banner_statistic-banner_id}}',
            '{{%banner_statistic}}'
        );

        $this->dropTable('{{%banner_statistic}}');
    }
}
