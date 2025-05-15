<?php

use yii\db\Migration;

class m250515_084259_trip_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%trip_user}}', [
            'trip_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'PRIMARY KEY(trip_id, user_id)',
        ]);

        $this->addForeignKey('fk-trip_user-trip_id', '{{%trip_user}}', 'trip_id', 'trip', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-trip_user-user_id', '{{%trip_user}}', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%trip_user}}');
    }
}
