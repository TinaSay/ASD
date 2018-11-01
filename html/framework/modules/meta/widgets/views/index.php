<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.07.18
 * Time: 15:51
 */

use tina\metatag\assets\MetatagAsset;

/** @var $this \yii\web\View */
/** @var $form \yii\widgets\ActiveForm */
/** @var $model \yii\base\Model */
/** @var $metatag \tina\metatag\models\Metatag */
/** @var $list array */

MetatagAsset::register($this);
?>
<div class="row" style="margin-bottom:30px;">
    <div class="col-md-6">
        <input type="checkbox" id="metatagSwitcher" class="switch">
        <label for="metatagSwitcher">Настройка метатегов</label>
    </div>
</div>

<div class="metatags">

    <h4>Общие метатеги</h4>
    <hr>

    <?= $form->field($metatag, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($metatag, 'commonTitle')->dropDownList($metatag::getCommonList()) ?>

    <?= $form->field($metatag, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($metatag, 'commonDescription')->dropDownList($metatag::getCommonList()) ?>

    <?= $form->field($metatag, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($metatag, 'commonKeywords')->dropDownList($metatag::getCommonList()) ?>

    <h4>Настройки Opengraph</h4>
    <hr>

    <?php foreach ($list as $row) : ?>

        <?= $row['content'] ?>

    <?php endforeach; ?>

</div>
