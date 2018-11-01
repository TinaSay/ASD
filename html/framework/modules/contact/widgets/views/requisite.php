<?php
use app\modules\contact\assets\ContactBackendAssets;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = ContactBackendAssets::register($this);
?>

<div class="form-group field-division-requisite-widget">
    <label class="control-label" for="division-requisite">Реквизиты</label>

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <input type="text" class="form-control" name="Requisite[name][]" placeholder="Название файла" value="">
                <input type="hidden" name="Division[requisite]" value=""><input type="file" id="division-requisite"
                                                                                name="Requisite[src][]">
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-success add-requisite-field">
                    <span class="glyphicon glyphicon-plus"></span> Добавить
                </button>
            </div>

        </div>
    </div>

</div>

<div id="requisite-holder" class="bg-green-metro"></div>


<?php if ($model->requisites): ?>
    <div id="requisite-holder-list" class="bg-green-metro">
        <?php foreach ($model->requisites as $requisite): ?>

            <div class="container field-division-requisite-widget" id="requisite-update-<?= $requisite->id ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="RequisiteUpdate[<?= $requisite->id ?>][name]"
                               value="<?= $requisite->name ?>">
                        <?= Html::a($requisite->name, Url::to($requisite->getFilePathUrl(), true), ['target' => '_blank']) ?>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-warning" onclick="requisiteDelete(<?= $requisite->id ?>)">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>



