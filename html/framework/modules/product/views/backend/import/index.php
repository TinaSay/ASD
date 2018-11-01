<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 14:49
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\queue\Queue;

$this->title = 'Импорт товаров';

/* @var $job array */
/* @var $stat array */
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">

        <?php if ($job): ?>
            <p class="well">
                Статус задачи импорта (<?= $job['id']; ?>):
                <?= $job['status'] === Queue::STATUS_DONE ? 'Выполнено' :
                    ($job['status'] === Queue::STATUS_WAITING ? 'Ожидает выполнения' : 'Выполняется');
                ?>
            </p>
        <?php endif; ?>
        <?= Html::beginForm(); ?>
        <?= Html::submitButton('Импортировать', [
            'value' => 1,
            'name' => 'import',
            'class' => 'btn btn-primary',
            'disabled' => ($job && $job['status'] !== Queue::STATUS_DONE)
        ]); ?>
        <?= Html::endForm(); ?>
    </div>
    <div class="card-header">
        <?php if ($stat): ?>
            <table class="table">
                <tr>
                    <td>Дата и время импорта</td>
                    <td>&nbsp;</td>
                    <td><?= Yii::$app->formatter->asDateTime(ArrayHelper::getValue($stat, 'date', '')); ?></td>
                </tr>
                <tr>
                    <td>Товаров добавлено</td>
                    <td>&nbsp;</td>
                    <td><?= ArrayHelper::getValue($stat, 'products.created', 0) ?></td>
                </tr>
                <tr>
                    <td>Товаров обновлено</td>
                    <td>&nbsp;</td>
                    <td><?= ArrayHelper::getValue($stat, 'products.updated', 0) ?></td>
                </tr>
                <tr>
                    <td>Товаров удалено</td>
                    <td>&nbsp;</td>
                    <td><?= ArrayHelper::getValue($stat, 'products.deleted', 0) ?></td>
                </tr>
                <tr>
                    <td>Файлов добавлено</td>
                    <td>&nbsp;</td>
                    <td><?php
                        $files = ArrayHelper::getValue($stat, 'file.created', []);
                        print count($files);
                        ?>
                        <?php if ($files): ?>
                            <a href="#files-created" data-toggle="collapse">Список файлов</a>
                            <ul class="collapse" id="files-created">
                                <li>
                                    <?= implode("</li><li>", $files) ?>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Файлов удалено</td>
                    <td>&nbsp;</td>
                    <td><?php
                        $files = ArrayHelper::getValue($stat, 'file.created', []);
                        print count($files);
                        ?>
                        <?php if ($files): ?>
                            <a href="#files-deleted" data-toggle="collapse">Список файлов</a>
                            <ul class="collapse" id="files-deleted">
                                <li>
                                    <?= implode("</li><li>", $files) ?>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Ошибки</td>
                    <td>&nbsp;</td>
                    <td>
                        <?= implode("<br />", ArrayHelper::getValue($stat, 'errors', [])); ?>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</div>
