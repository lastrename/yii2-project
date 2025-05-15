<?php

use app\models\Trip;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TripSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Командировка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trip-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить командировку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->id, ['trip/view', 'id' => $model->id]);
                },
            ],
            'title',
            [
                'label' => 'Начало командировки',
                'attribute' => 'start_date',
                'format' => ['date', 'php:d.m.Y'],
                'value' => function ($model) {
                    /** @var app\models\Trip $model */
                    return $model->startDate;
                },
            ],
            [
                'label' => 'Окончание командировки',
                'attribute' => 'end_date',
                'format' => ['date', 'php:d.m.Y'],
                'value' => function ($model) {
                    /** @var app\models\Trip $model */
                    return $model->endDate;
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Trip $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
