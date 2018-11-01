<?php

use app\modules\contact\assets\ContactBackendAssets;
use yii\jui\AutoComplete;

$bundle = ContactBackendAssets::register($this);
?>
<?= $form->field($model, 'metro')->widget(AutoComplete::class,
    [
        'options' => ['class' => 'form-control', 'style' => 'display:none;']
    ]) ?>

<div class="form-group field-division-metrocomplete">
    <label class="control-label" for="division-metrocomplete">Ближайшие станции метро</label>

    <input type="text" id="division-metrocomplete" class="form-control" autocomplete="off" aria-invalid="false">

    <div class="help-block"></div>
</div>
<div id="metro-holder">
    <?php if ($model->metros): ?>
        <?php foreach ($model->metros as $metro): ?>

            <fieldset id="metro-update-<?= $metro->id ?>" class="bg-green-metro">
                <div class="form-group field-division-metro-log"><label class="control-label">Название
                        станции</label><input type="text" class="form-control"
                                              name="MetroUpdate[<?= $metro->id ?>][name]" value="<?= $metro->name ?>"
                                              style="width: 200px;" readonly="readonly">
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-division-metro-log"><label class="control-label">Расстояние</label><input
                        type="text" class="form-control" name="MetroUpdate[<?= $metro->id ?>][distance]"
                        value="<?= $metro->distance ?>" style="width: 100px;">
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-division-metro-log"><label class="control-label">Цвет</label><input
                        type="text" class="form-control" name="MetroUpdate[<?= $metro->id ?>][color]"
                        value="<?= $metro->color ?>" style="width: 100px;">
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-division-metro-log">
                    <button type="button" class="btn btn-warning" onclick="metroDelete(<?= $metro->id ?>)">Удалить
                    </button>
                </div>
            </fieldset>

        <?php endforeach; ?>
    <?php endif; ?>
</div>


