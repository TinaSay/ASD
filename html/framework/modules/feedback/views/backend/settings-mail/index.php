<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\reception\form\SettingsMailForm */

$this->title = Yii::t('system', 'Settings mail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Settings mail'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Update'), ['update'], [
                'class' => 'btn btn-primary'
            ]) ?>
        </p>
    </div>

    <div class="card-content">
        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => [
                'sender_name',
                'host',
                'username',
                'hidden_password',
                'port',
                'encryption',
            ],
        ]) ?>
    </div>
</div>
