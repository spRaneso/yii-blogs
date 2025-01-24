<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogs}}`.
 */
class m250122_091037_create_blogs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blogs}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => "ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'",
            'approved_by' => $this->integer()->defaultValue(null),
            'approved_at' => $this->timestamp()->defaultValue(null),
            'rejected_by' => $this->integer()->defaultValue(null),
            'rejected_at' => $this->timestamp()->defaultValue(null),
            'deleted_by' => $this->integer()->defaultValue(null),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blogs}}');
    }
}
