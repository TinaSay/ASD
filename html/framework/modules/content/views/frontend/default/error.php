<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use app\modules\news\widgets\NewsSubscribeWidget;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
$this->params['hideBreadcrumbs'] = true;

?>
<?php if (property_exists($exception, 'statusCode') && $exception->statusCode == '404'): ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="section-title h2">К сожалению, данная информация отсутствует на сайте</h1>
                    <div class="section-date"></div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="text-block text-gray txt-18">
                        <p>
                            <strong>
                                Текущая страница – это сообщение об ошибке «404» или по-английски Not Found («не
                                найдено»).
                            </strong>
                        </p>
                        <p>
                            Похоже, что мы скрыли или удалили эту страницу.
                        </p>
                        <p>
                            Если вы считаете, что здесь обязательно что-то должно быть, пожалуйста, <a href="<?= Url::to(['/contacts']) ?>">свяжитесь с нами</a> и
                            мы постараемся решить этот вопрос.
                        </p>
                        <p>
                            А пока вы можете перейти на главную страницу нашего сайта – <a
                                    href="<?= Url::home(true); ?>"><?= Url::home(true); ?></a>
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </section>
<?php else: ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="section-title h2"><?= Html::encode($this->title) ?></h1>
                    <div class="section-date"></div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="text-block text-gray txt-18">
                        <div class="alert alert-danger">
                            <?= nl2br(Html::encode($message)) ?>
                        </div>

                        <p>
                            The above error occurred while the Web server was processing your request.
                        </p>
                        <p>
                            Please contact us if you think this is a server error. Thank you.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </section>
<?php endif; ?>
<!-- section-request -->
<?= NewsSubscribeWidget::widget(); ?>



