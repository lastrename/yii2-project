<?php

use app\models\Service;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Service $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="service-form">

    <div class="service-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'status')->dropDownList(Service::getStatusList(), ['prompt' => 'Выберите статус']) ?>

        <?= $form->field($model, 'type')->dropDownList(Service::getTypeList(), ['prompt' => 'Выберите тип услуги', 'id' => 'service-type']) ?>

        <div id="service-details-form">
            <?php
                if ($model->type === 'train') {
                    echo $this->render('_form_train', ['model' => $model]);
                } elseif ($model->type === 'flight') {
                    echo $this->render('_form_flight', ['model' => $model]);
                } elseif ($model->type === 'hotel') {
                    echo $this->render('_form_hotel', ['model' => $model]);
                }
            ?>
        </div>

        <div class="form-group mt-4">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$loadDetailsUrl = Url::to(['service/load-details-form']);

$js = <<<JS
$('#service-type').on('change', function() {
    const type = $(this).val();
    $.get('$loadDetailsUrl', {type}, function(data) {
        $('#service-details-form').html(data);
    });
});
JS;
$this->registerJs($js);
?>