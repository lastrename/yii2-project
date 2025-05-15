<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "service_user".
 *
 * @property int $service_id
 * @property int $user_id
 *
 * @property Service $service
 * @property User $user
 */
class ServiceUser extends ActiveRecord
{
    public array $user_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'service_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['trip_id', 'service_id', 'start_date', 'end_date'], 'required'],
            [['trip_id', 'service_id'], 'integer'],
            ['user_ids', 'each', 'rule' => ['integer']],
            [['start_date', 'end_date'], 'safe'],
            [['service_id', 'user_id'], 'unique', 'targetAttribute' => ['service_id', 'user_id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'service_id' => 'ServiceController ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
