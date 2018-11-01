<?php

use app\modules\news\widgets\NewsSubscribeWidget;

/* @var $this yii\web\View */
/* @var $dto \app\modules\content\dto\frontend\ContentDto */

$this->title = $dto->getTitle();

?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="section-title h2"><?= $this->title ?></h1>
                <div class="section-date"></div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="text-block text-gray txt-18">
                    <?= $dto->getText() ?>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- section-request -->
<?= NewsSubscribeWidget::widget(); ?>
