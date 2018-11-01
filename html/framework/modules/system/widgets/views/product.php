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
                <a href="<?= Url::to(['/product/product']) ?>">
                    <div class="col-xs-5">
                        <div class="icon-big icon-color-1"><i class="ti-package"></i></div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Общее количество товаров</p> <?= $count ?>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>