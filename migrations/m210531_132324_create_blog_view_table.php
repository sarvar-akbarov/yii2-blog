<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_view}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog}}`
 */
class m210531_132324_create_blog_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_view}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer()->comment("Блог"),
            'date_cr' => $this->datetime()->comment("Дата просмотра"),
            'user_ip' => $this->string(255)->comment("Ip пользователья"),
            'user_agent' => $this->string(255)->comment("Браузер пользователья"),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            '{{%idx-blog_view-blog_id}}',
            '{{%blog_view}}',
            'blog_id'
        );

        // add foreign key for table `{{%blog}}`
        $this->addForeignKey(
            '{{%fk-blog_view-blog_id}}',
            '{{%blog_view}}',
            'blog_id',
            '{{%blog}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%blog}}`
        $this->dropForeignKey(
            '{{%fk-blog_view-blog_id}}',
            '{{%blog_view}}'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            '{{%idx-blog_view-blog_id}}',
            '{{%blog_view}}'
        );

        $this->dropTable('{{%blog_view}}');
    }
}
