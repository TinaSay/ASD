<?php
/**
 * Created by PhpStorm.
 * User: rustam
 * Date: 06.04.2018
 * Time: 13:08
 */
?>
<div class="col-md-12">
    <div class="card card-user-hello">
        <div class="card-header">
            <div class="card-header__inner">
                <i class="card-user-hello__icon"></i>
                <h4 class="card-title">Добро пожаловать!</h4>
                <p class="category">Вы авторизовались, как <a
                            href="<?= \yii\helpers\Url::to(['/auth/auth/view', 'id' => $user->getId()]) ?>"><?= $user->getLogin(); ?></a>
                </p>
            </div>
        </div>
        <div class="card-footer">
            <p class="category">
                <i class="ti-time"></i>Ваше последнее посещение панели администратора:<br>
                <span><?= Yii::$app->getFormatter()->asDateTime($authLog->created_at, 'dd MMMM yyyy года в HH:mm') ?></span>
            </p>
        </div>
    </div>
</div>