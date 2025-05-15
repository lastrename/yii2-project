<?php
/** @var $model app\models\Service */
$details = $model->details ?? [];
?>

<h4>Детали поездки на поезде</h4>

<div class="row">
    <div class="col-md-6">
        <label>Номер поезда</label>
        <input type="text" name="Service[details][train_number]" class="form-control" value="<?= $details['train_number'] ?? '' ?>">
    </div>
    <div class="col-md-6">
        <label>Вагон</label>
        <input type="text" name="Service[details][carriage]" class="form-control" value="<?= $details['carriage'] ?? '' ?>">
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-6">
        <label>Место</label>
        <input type="text" name="Service[details][seat]" class="form-control" value="<?= $details['seat'] ?? '' ?>">
    </div>
    <div class="col-md-6">
        <label>Станция отправления</label>
        <input type="text" name="Service[details][departure_station]" class="form-control" value="<?= $details['departure_station'] ?? '' ?>">
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-6">
        <label>Станция прибытия</label>
        <input type="text" name="Service[details][arrival_station]" class="form-control" value="<?= $details['arrival_station'] ?? '' ?>">
    </div>
</div>
