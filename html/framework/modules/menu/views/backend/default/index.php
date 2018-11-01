<?php

use krok\extend\widgets\tree\TreeWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel elfuvo\menu\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $useSection boolean */
/* @var $section string */
/* @var $tree \elfuvo\menu\models\Menu[] */

$this->title = Yii::t('system', 'Menu');
$this->params['breadcrumbs'][] = $this->title;

// sortable
$url = Url::to(['update-all']);


?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <?php if ($useSection): ?>
        <div class="card-header">
            <p>
                <?= Html::a(Yii::t('system', 'Create'), ['create', 'section' => $section], [
                    'class' => 'btn btn-success',
                ]) ?>
            </p>
        </div>
    <?php else: ?>
        <div class="card-header">
            <p>
                <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                    'class' => 'btn btn-success',
                ]) ?>
            </p>
        </div>
    <?php endif; ?>


    <div class="card-content">

        <?= TreeWidget::widget([
            'attributeContent' => 'title',
            'items' => $tree,
            'clientEvents' => [
                'update' => 'function (event, ui) { jQuery(this).sortableWidget({url: \'' . $url . '\'}) }',
            ],
            'additionalControls' => [
                'add-item' => function ($item) use ($useSection, $section) {

                    return Html::a('<i class="add-item glyphicon glyphicon-plus" title="Создать дочерний элемент"></i>',
                        (
                        $useSection ?
                            ['create', 'section' => $section, 'parentId' => $item['id']] :
                            ['create', 'parentId' => $item['id']]
                        )
                    );
                },
            ],
        ]) ?>

    </div>
</div>
