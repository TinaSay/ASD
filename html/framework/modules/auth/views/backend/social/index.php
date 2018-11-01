<?php
/* @var $this yii\web\View */

use yii\authclient\widgets\AuthChoice;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('system', 'Social network');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <div class="panel panel-default">
            <div class="panel-heading">
                <?= sprintf('Привязка аккаунта <b>%s</b> к социальным сетям',
                    ArrayHelper::getValue(Yii::$app->getUser()->getIdentity(), 'login')) ?>
            </div>
            <div class="panel-body">
                <?= AuthChoice::widget([
                    'popupMode' => false,
                    'autoRender' => true,
                    'baseAuthUrl' => ['/auth/default/oauth'],
                ]) ?>
            </div>
        </div>

    </div>
</div>
