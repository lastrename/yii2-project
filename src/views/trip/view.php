<?php

use app\models\Service;
use app\models\ServiceUser;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Trip $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Командировка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="trip-view">

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
                'label' => 'Пользователи',
                'format' => 'text',
                'value' => function($model) {
                    return implode(', ', ArrayHelper::getColumn($model->users, 'full_name'));
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <div class="d-flex gap-4 justify-content-between w-100">
        <div class="w-50">
            <h3>Участники командировки</h3>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->tripUsers as $tripUser): ?>

                    <?php
                        $user = $tripUser->user;
                        $start = $user->getTripStartDate($model->id);
                        $end = $user->getTripEndDate($model->id);
                    ?>

                    <tr>
                        <td><?= Html::encode($tripUser->user->full_name) ?></td>
                        <td><?= $start ? Yii::$app->formatter->asDate($start) : 'Нет данных' ?></td>
                        <td><?= $end ? Yii::$app->formatter->asDate($end) : 'Нет данных' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="w-50">
            <div>
                <h4>Услуги командировки</h4>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->services as $services): ?>
                        <tr>
                            <td><?= Html::encode($services->title) ?></td>
                            <td><?= Html::encode(Service::getTypeList()[$services->type]) ?></td>
                            <td><?= Html::encode(Service::getStatusList()[$services->status]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?= Html::button('Добавить услугу', [
                'class' => 'btn btn-success',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#addServiceModal',
            ]) ?>

        </div>
    </div>

</div>

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php
            $serviceModel = new ServiceUser();

            $form = ActiveForm::begin([
                'action' => ['trip/add-service'],
                'id' => 'add-service-form',
            ]); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Добавить услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($serviceModel, 'trip_id')->hiddenInput(['value' => $model->id])->label(false) ?>

                <?= $form->field($serviceModel, 'service_id')->dropDownList(
                    ArrayHelper::map(
                        Service::find()->all(),
                        'id',
                        'title'
                    ),
                    ['prompt' => 'Выберите услугу']
                ) ?>

                <?= $form->field($serviceModel, 'start_date')->input('date', [
                    'value' => date('Y-m-d', strtotime($model->start_at ?? 'now'))
                ]) ?>
                <?= $form->field($serviceModel, 'end_date')->input('date', [
                    'value' => date('Y-m-d', strtotime($model->end_at ?? 'now'))
                ]) ?>

                <?= $form->field($serviceModel, 'user_ids[]')->checkboxList(
                    ArrayHelper::map($model->tripUsers, 'user_id', fn($u) => $u->user->full_name)
                )->label('Участники') ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
