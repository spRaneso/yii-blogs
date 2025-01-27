<?php

use yii\db\Migration;

/**
 * Class m250122_091215_seed_users_table
 */
class m250122_091215_seed_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('users', ['username', 'full_name', 'email', 'password', 'role'], [
            ['admin', 'Admin', 'admin@mail.com', Yii::$app->getSecurity()->generatePasswordHash('Admin@123'), 'admin'],
            ['ram', 'Ram', 'ram@mail.com', Yii::$app->getSecurity()->generatePasswordHash('User@123'), 'user'],
            ['shyam', 'Shyam', 'shyam@mail.com', Yii::$app->getSecurity()->generatePasswordHash('User@123'), 'user'],
            ['surya', 'Surya', 'surya@mail.com', Yii::$app->getSecurity()->generatePasswordHash('User@123'), 'user'],
            ['rahul', 'Rahul', 'rahul@mail.com', Yii::$app->getSecurity()->generatePasswordHash('User@123'), 'user'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['username' => ['admin', 'user1', 'user2']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250122_091215_seed_users_table cannot be reverted.\n";

        return false;
    }
    */
}
