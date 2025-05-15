<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Service $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Сервисы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'type',
                'value' => $model->getTypeList()[$model->type],
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatusList()[$model->status],
            ],
            [
                'label' => 'Детали',
                'format' => 'raw',
                'value' => function ($model) {
                    $details = $model->details;

                    if (empty($details) || !is_array($details)) {
                        return '<em>(нет данных)</em>';
                    }

                    return match ($model->type) {
                        'train' => '
                    <strong>Номер поезда:</strong> ' . ($details['train_number'] ?? '-') . '<br>
                    <strong>Вагон:</strong> ' . ($details['carriage'] ?? '-') . '<br>
                    <strong>Место:</strong> ' . ($details['seat'] ?? '-') . '<br>
                    <strong>Откуда:</strong> ' . ($details['departure_station'] ?? '-') . '<br>
                    <strong>Куда:</strong> ' . ($details['arrival_station'] ?? '-') . '<br>
                ',
                        'flight' => '
                    <strong>Рейс:</strong> ' . ($details['flight_number'] ?? '-') . '<br>
                    <strong>Класс:</strong> ' . ($details['class'] ?? '-') . '<br>
                    <strong>Место:</strong> ' . ($details['seat'] ?? '-') . '<br>
                    <strong>Багаж включён:</strong> ' . (isset($details['baggage_included']) ? ($details['baggage_included'] ? 'Да' : 'Нет') : '-') . '<br>
                    <strong>Откуда:</strong> ' . ($details['departure_airport'] ?? '-') . '<br>
                    <strong>Куда:</strong> ' . ($details['arrival_airport'] ?? '-') . '<br>
                ',
                        'hotel' => '
                    <strong>Отель:</strong> ' . ($details['hotel_name'] ?? '-') . '<br>
                    <strong>Локация:</strong> ' . ($details['location'] ?? '-') . '<br>
                    <strong>Номер:</strong> ' . ($details['room_number'] ?? '-') . '<br>
                    <strong>Питание включено:</strong> ' . (isset($details['meals_included']) ? ($details['meals_included'] ? 'Да' : 'Нет') : '-') . '<br>
                ',
                        default => '<em>(детали для этого типа не предусмотрены)</em>',
                    };
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
