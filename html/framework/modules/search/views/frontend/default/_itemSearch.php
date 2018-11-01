<?php
/* @var $this yii\web\View */
/* @var $numModel integer */
/* @var $model array */
?>
<li data-type="<?= $model['type'] ?>">
    <a href="<?= $model['url'] ?>">
        <i class="num"><?= $numModel ?></i>
        <div class="title"><?= $model['title'] ?></div>
        <div class="text"><?= $model['snippet'] ?></div>
        <div class="bottom-text"><?= $model['module'] ?></div>
    </a>
</li>
