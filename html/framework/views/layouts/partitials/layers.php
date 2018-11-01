<?php

use app\modules\feedback\widget\feedback\FeedbackWidget;
use app\modules\lk\widgets\login\LoginWidget;

?>
<div id="page-cooperation" class="page-layer page-cooperation">
    <span class="close-page-layer"></span>
    <div class="page-layer__inner scroll"></div>
</div>
<div id="page-tel" class="page-layer page-tel-layer page-tel page-auth">
    <span class="close-page-layer"></span>
    <div class="page-layer__inner scroll">
        <div class="page-tel__wrap">
            <div class="container-fluid">
                <div class="col-xs-12">
                    <h2 class="section-title">Обратный звонок</h2>
                    <div class="section-title__description">Оставьте свой номер и мы перезвоним вам в удобное для вас
                        время
                    </div>
                    <div class="white-block white-block-tel white-block--wide">

                        <?= FeedbackWidget::widget([
                            'view' => 'from_menu_callback_mini',
                            'cssClass' => '',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= LoginWidget::widget() ?>