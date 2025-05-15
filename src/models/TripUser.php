<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "trip_user".
 *
 * @property int $trip_id
 * @property int $user_id
 *
 * @property Trip $trip
 * @property User $user
 */
class TripUser extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['trip_id', 'user_id'], 'required'],
            [['trip_id', 'user_id'], 'default', 'value' => null],
            [['trip_id', 'user_id'], 'integer'],
            [['trip_id', 'user_id'], 'unique', 'targetAttribute' => ['trip_id', 'user_id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trip::class, 'targetAttribute' => ['trip_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'trip_id' => 'Trip ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTrip(): ActiveQuery
    {
        return $this->hasOne(Trip::class, ['id' => 'trip_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
