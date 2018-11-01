<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 03.05.18
 * Time: 15:21
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $configurable \krok\configure\ConfigurableInterface|\yii\base\Model|\app\modules\product\meta\MetaTemplateInterface */
?>
<div class="card-content">

    <?php $form = ActiveForm::begin(['action' => ['save']]); ?>

    <?= Html::hiddenInput('class', get_class($configurable)) ?>

    <?php foreach ($configurable::attributeTypes() as $attribute => $item) : ?>
        <div class="input-container">
            <?php if (is_array($item)) : ?>
                <?= $form->field($configurable, $attribute)->widget($item['class'], $item['config'] ?? []) ?>
            <?php elseif (is_string($item)) : ?>
                <?= $form->field($configurable, $attribute)->input($item) ?>
            <?php endif; ?>

            <?= $this->render('_template_attributes', [
                'attributes' => $configurable->getModelTemplateAttributes()
            ]); ?>
        </div>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('system', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
