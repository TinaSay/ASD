<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\product\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('system', 'Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">
        <?php
        $documents = '';
        if ($model->getDocuments()) {
            foreach ($model->getDocuments() as $document) {
                $documents .= '<p>' . Html::a($document->getTitle(), $model->getDocumentUrl($document)) . '</p>';
            }
        }

        $related = '';
        if ($model->relatedProducts) {
            foreach ($model->relatedProducts as $product) {
                $related .= '<p>' . Html::a($product->title, ['view', 'id' => $product->id]) . '</p>';
            }
        }

        $attributes = [
            'id',
            'uuid',
            'article',
            'title',
            'printableTitle',
            [
                'attribute' => 'brandId',
                'value' => ($model->brand ? $model->brand->title : null),
            ],
            [
                'attribute' => 'sectionId',
                'value' => $model->getSectionsAsString(),
            ],
            [
                'attribute' => 'usageId',
                'value' => $model->getUsagesAsString(),
            ],
            [
                'attribute' => 'clientCategoryId',
                'value' => $model->getClientCategoriesAsString(),
            ],
            [
                'attribute' => 'documents',
                'value' => $documents,
                'format' => 'raw',
            ],
            'description',
            [
                'attribute' => 'advantages',
                'value' => $model->advantages ? '<ul><li>' . implode('</li><li>',
                        $model->advantages) . '</li></ul>' : '',
                'format' => 'raw',
            ],
            'text:html',
            [
                'attribute' => 'hidden',
                'value' => $model->getHidden(),
            ],
            [
                'attribute' => 'relatedProducts',
                'value' => $related,
                'format' => 'raw',
            ],
        ];
        if ($properties = $model->getPropertyValues()) {
            foreach ($properties as $property) {
                array_push($attributes, [
                    'label' => $property->getTitle(),
                    'value' => $property->getValue(),
                ]);
            }
        }
        if ($model->additionalParams) {
            foreach ($model->additionalParams as $param) {
                array_push($attributes, [
                    'label' => $param['title'],
                    'value' => $param['value'],
                ]);
            }
        }
        if ($model->videos) {
            $videos = '';
            foreach ($model->videos as $url) {
                $videos .= '<div class="row"><div class="col-md-12">' .
                    '<iframe width="560" height="315" src="' . $url . '" ' .
                    'frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' .
                    '</div></div>';
            }
            array_push($attributes, [
                'attribute' => 'videos',
                'value' => $videos,
                'format' => 'raw',
            ]);
        }
        array_push($attributes, 'createdAt:datetime');
        array_push($attributes, 'updatedAt:datetime');
        ?>

        <?= DetailView::widget([
            'options' => ['class' => 'table'],
            'model' => $model,
            'attributes' => $attributes,
        ]) ?>

    </div>
</div>
