<?php
/** @var app\models\Service $model */
?>

<div class="form-group">
    <label for="details-flight_class">Класс перелёта</label>
    <input type="text" id="details-flight_class" name="Service[details][flight_class]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['flight_class'] ?? '') ?>">
</div>

<div class="form-group">
    <label for="details-seat_number">Номер места</label>
    <input type="text" id="details-seat_number" name="Service[details][seat_number]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['seat_number'] ?? '') ?>">
</div>

<div class="form-group form-check">
    <input type="checkbox" id="details-baggage_included" name="Service[details][baggage_included]" class="form-check-input" value="1" <?= !empty($model->details['baggage_included']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="details-baggage_included">Включён багаж</label>
</div>

<div class="form-group">
    <label for="details-departure_airport">Аэропорт отправления</label>
    <input type="text" id="details-departure_airport" name="Service[details][departure_airport]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['departure_airport'] ?? '') ?>">
</div>

<div class="form-group">
    <label for="details-arrival_airport">Аэропорт прибытия</label>
    <input type="text" id="details-arrival_airport" name="Service[details][arrival_airport]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['arrival_airport'] ?? '') ?>">
</div>