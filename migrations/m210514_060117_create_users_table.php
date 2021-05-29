<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m210514_060117_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'username' => $this->string(255),
            'auth_key' => $this->string(255),
            'password_hash' => $this->string(255),
            'password_reset_token' => $this->string(255),
            'email' => $this->string(255),
            'email_verification_key' => $this->string(255),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->datetime()->defaultValue(date('Y-m-d H:i:s')),
            'updated_at' => $this->datetime()->defaultValue(date('Y-m-d H:i:s')),
            'selected_language' => $this->string(5)->defaultValue('ru'),
        ]);

        $this->insert('{{%users}}',array(
            'first_name' => 'Sarvar',
            'last_name' => 'Akbarov',
            'username' => 'akbarov',
            'status' => 1,
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
          ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
