<?php
/**
 * Created by PhpStorm.
 * User: rustam
 * Date: 06.04.2018
 * Time: 13:08
 */

use yii\helpers\Url;

?>
<div class="col-md-6 col-sm-12">
    <div class="card">
        <div class="card-content">
            <div class="row">
                <a href="<?= Url::to(['/feedback/default']) ?>">
                    <div class="col-xs-5">
                        <div class="icon-big icon-color-2"><i class="ti-email"></i></div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Необработанных обращений</p> <?= $count ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>