<?php

use yii\db\Migration;

/**
 * Class m210531_141551_add_default_values
 */
class m210531_141551_add_default_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
