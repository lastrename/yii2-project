<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string $status
 * @property string $details
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ServiceUser[] $serviceUsers
 * @property Trip $trip
 * @property User[] $users
 */
class Service extends ActiveRecord
{
    // Статусы
    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DRAFT = 'draft';

    // Типы услуг
    public const TYPE_FLIGHT = 'flight';
    public const TYPE_TRAIN = 'train';
    public const TYPE_HOTEL = 'hotel';
    public const TYPE_TAXI = 'taxi';
    public const TYPE_VISA = 'visa';
    public const TYPE_RESTAURANT = 'restaurant';
    public const TYPE_OTHER = 'other';


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
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type', 'status'], 'required'],
            [['title', 'type', 'status'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
            ['details', 'default', 'value' => []],
            ['details', 'validateDetailsArray'],
        ];
    }

    public function validateDetailsArray($attribute, $params)
    {
        if (!is_array($this->$attribute)) {
            $this->addError($attribute, 'Details должно быть массивом.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название услуги',
            'type' => 'Тип услуги',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->details)) {
                $this->details = json_encode($this->details);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();

        if (is_string($this->details)) {
            $this->details = json_decode($this->details, true) ?: [];
        } elseif (!is_array($this->details)) {
            $this->details = [];
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceUsers(): ActiveQuery
    {
        return $this->hasMany(ServiceUser::class, ['service_id' => 'id']);
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
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('service_user', ['service_id' => 'id']);
    }

    // Справочник статусов
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активна',
            self::STATUS_CANCELLED => 'Отменена',
            self::STATUS_COMPLETED => 'Завершена',
            self::STATUS_DRAFT => 'Черновик',
        ];
    }

    // Справочник типов услуг
    public static function getTypeList(): array
    {
        return [
            self::TYPE_FLIGHT => 'Авиаперелёт',
            self::TYPE_TRAIN => 'Поезд',
            self::TYPE_HOTEL => 'Гостиница',
            self::TYPE_TAXI => 'Такси / трансфер',
            self::TYPE_VISA => 'Виза',
            self::TYPE_RESTAURANT => 'Ресторан',
            self::TYPE_OTHER => 'Другое',
        ];
    }
}
