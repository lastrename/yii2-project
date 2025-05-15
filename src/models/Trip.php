<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "trip".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Service[] $services
 * @property TripUser[] $tripUsers
 * @property User[] $users
 */
class Trip extends ActiveRecord
{
    public array $user_ids = [];

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'trip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'user_ids'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['user_ids', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'user_ids' => 'Пользователи',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceLinks()
    {
        return $this->hasMany(ServiceUser::class, ['trip_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->via('serviceLinks');
    }

    public function getStartDate(): ?int
    {
        $dates = array_column($this->serviceLinks, 'start_date');
        return $dates ? min(array_map('strtotime', $dates)) : null;
    }

    public function getEndDate(): ?int
    {
        $dates = array_column($this->serviceLinks, 'end_date');
        return $dates ? max(array_map('strtotime', $dates)) : null;
    }

    /**
     * @return ActiveQuery
     */
    public function getTripUsers(): ActiveQuery
    {
        return $this->hasMany(TripUser::class, ['trip_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('trip_user', ['trip_id' => 'id']);
    }

}
