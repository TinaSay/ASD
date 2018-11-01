<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\lk\widgets\assets\LoginAsset;

/* @var $model app\modules\lk\forms\LoginForm */

LoginAsset::register($this);
?>
<!-- авторизация -->
<div id="page-auth" class="page-layer page-tel">
    <span class="close-page-layer"></span>
    <div class="page-layer__inner scroll">
        <div class="page-tel__wrap">
            <div class="container-fluid">
                <div class="col-xs-12">
                    <h2 class="section-title">Личный кабинет клиента</h2>
                    <div class="section-title__description">Для авторизации используйте логин и пароль, полученные у Вашего персонального менеджера.</div>
                    <div class="white-block white-block-tel white-block--wide">
                        <?php $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                            'validateOnSubmit' => true,
                            'action' => Url::to(['/lk/default/login']),
                            'options' => [
                                'id' => 'formAuth',
                                'class' => 'tab-auth active',
                                'data-tab' => "auth-form"
                            ],
                        ]); ?>
                        <?php /*<form id="formAuth" data-tab="auth-form" class="tab-auth active" method="post" action="">*/?>
                            <div class="form-inner">
                                <div class="form-group">
                                    <label class="form-group__label">Ваш логин</label>
                                    <?php /*<input type="text" class="form-control" required name="name">*/ ?>
                                    <?= Html::activeInput('text', $model, 'login', ['class' => 'form-control']) ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-group__label">Ваш пароль <?php /*<a data-toggle="auth-forget" class="forget-password pull-right tab-auth-link" href="#">Забыли пароль?</a>*/ ?></label>
                                    <?php /*<input type="password" class="form-control" required name="password">*/ ?>
                                    <?= Html::activeInput('password', $model, 'password', ['class' => 'form-control']) ?>
                                </div>
                                <div class="row row-spinner" style="display: none;">
                                    <div class="spinner"></div>
                                </div>
                                <div class="btn-and-info form-btn btn-and-info--column">
                                    <?php /*<button class="btn btn-primary btn-confirm">Войти</button>*/ ?>
                                    <?= Html::submitButton('Войти', [
                                        'id' => 'enter-lk',
                                        'class' => 'btn btn-primary btn-confirm'
                                    ]) ?>
                                </div>
                            </div>
                        <?php /*</form>*/ ?>
                        <?php ActiveForm::end(); ?>
                        <?php /*
                        <div data-tab="auth-forget" class="forget-password-info tab-auth auth-forget">
                            <h5 class="title">Восстановить пароль</h5>
                            <div class="text">Для восстановления доступа к личному кабинета, пожалуйста, свяжитесь с Вашим персональным менеджером.</div>
                            <div class="form-group">
                                <button data-toggle="auth-form" class="btn-block btn btn-default tab-auth-link">Войти</button>
                            </div>
                        </div>*/ ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>