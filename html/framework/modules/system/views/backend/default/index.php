<?php

/* @var $this yii\web\View */

use app\modules\system\widgets\FeedbackCountWidget;
use app\modules\system\widgets\ProductCountWidget;
use app\modules\system\widgets\WelcomeWidget;
use krok\paperDashboard\widgets\analytics\AnalyticsWidget;
use krok\paperDashboard\widgets\analytics\SpaceCircleChart;
use krok\paperDashboard\widgets\logging\LoggingWidget;

$this->title = 'Администрирование';


?>
<div class="row">
    <div class="style-card">
        <div class="col-lg-12">
            <div class="row">
                <?= WelcomeWidget::widget() ?>
                <?= ProductCountWidget::widget() ?>
                <?= FeedbackCountWidget::widget() ?>
                <?= LoggingWidget::widget() ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row">


                <div class="two-card-info">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Общие характеристики системы</h4>
                            </div>
                            <div class="card-content">
                                <ul class="system-info-list">
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'os/version', 'constructor' => ['s']]) ?>
                                    </li>
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'database/info']) ?>
                                    </li>
                                    <li>
                                        <?= AnalyticsWidget::widget(['name' => 'php/version']) ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <?= SpaceCircleChart::widget() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
