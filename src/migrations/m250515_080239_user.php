<?php

use app\models\User;
use yii\db\Migration;

class m250515_080239_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'full_name' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'role' => $this->string()->notNull()->defaultValue(User::ROLE_USER),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // создаем админа
        $password = Yii::$app->security->generatePasswordHash('admin123');
        $authKey = Yii::$app->security->generateRandomString();

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => $password,
            'auth_key' => $authKey,
            'role' => User::ROLE_ADMIN,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
