<?php

use yii\db\Migration;

class m250515_084311_service_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_user}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey('fk-trip_service-user', '{{%service_user}}', 'trip_id', '{{%trip}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-trip_service', '{{%service_user}}', 'service_id', '{{%service}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_user}}');
    }
}
