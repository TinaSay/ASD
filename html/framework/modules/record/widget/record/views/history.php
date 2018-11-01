<?php

use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $records \app\modules\record\models\Record[] */
?>
<?php if ($records): ?>
    <!-- section-history -->
    <section class="section section-history cbp-so-section">
        <div class="cbp-so-side-top cbp-so-side">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section-title-nav">
                            <div class="title">
                                <h2 class="section-title">20 лет – большой успех!</h2>
                                <div class="section-title__description">История одной компании</div>
                            </div>
                            <div class="history-slide__nav history-slide__nav--top">
                                <span class="prev"><span class="icon-arrow"></span></span>
                                <span class="next"><span class="icon-arrow"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="history-slide">
                            <?php foreach ($records as $record): ?>
                                <div class="history-slide__item">
                                    <div class="img">
                                        <?= Html::img($record->getPreview()) ?>
                                        <span class="fira">год</span>
                                    </div>
                                    <div class="text">
                                        <ul class="history-inner-slider">
                                            <?= $record->description; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="history-slide-year">
                            <ul class="fira">
                                <?php foreach ($records as $record): ?>
                                    <li><?= $record->year ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>