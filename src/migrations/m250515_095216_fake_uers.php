<?php

use app\models\User;
use Faker\Factory;
use yii\db\Migration;

class m250515_095216_fake_uers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $username = $faker->unique()->userName;
            $fullName = $faker->name;
            $email = $faker->unique()->safeEmail;
            $password = 'password123';

            $this->insert('user', [
                'username' => $username,
                'full_name' => $fullName,
                'email' => $email,
                'password_hash' => Yii::$app->security->generatePasswordHash($password),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'role' => 'USER',
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(User::tableName(), ['role' => 'USER']);
    }
}
