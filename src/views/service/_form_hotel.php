<?php
/** @var app\models\Service $model */
?>

<div class="form-group">
    <label for="details-hotel_name">Название отеля</label>
    <input type="text" id="details-hotel_name" name="Service[details][hotel_name]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['hotel_name'] ?? '') ?>">
</div>

<div class="form-group">
    <label for="details-location">Локация</label>
    <input type="text" id="details-location" name="Service[details][location]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['location'] ?? '') ?>">
</div>

<div class="form-group form-check">
    <input type="checkbox" id="details-breakfast_included" name="Service[details][breakfast_included]" class="form-check-input" value="1" <?= !empty($model->details['breakfast_included']) ? 'checked' : '' ?>>
    <label class="form-check-label" for="details-breakfast_included">Включено питание</label>
</div>

<div class="form-group">
    <label for="details-room_number">Номер комнаты</label>
    <input type="text" id="details-room_number" name="Service[details][room_number]" class="form-control" maxlength="255" value="<?= htmlspecialchars($model->details['room_number'] ?? '') ?>">
</div>