<?php

use yii\db\Migration;

class m250515_084241_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'details' => $this->json()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service}}');
    }
}
