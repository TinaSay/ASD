<?php

use yii\helpers\Url;

/* @var $sort \yii\data\Sort */
/* @var $searchModel app\modules\lk\models\OrderSearch */
/* @var $provider yii\data\ActiveDataProvider */
?>
<div class="lk-list">
    <ul class="lk-list__table">
        <li class="lk-list__head">
            <div class="li-inner">
                <div class="date <?= Yii::$app->request->get('sort') == 'createdAtDate' || Yii::$app->request->get('sort') == '-createdAtDate' || Yii::$app->request->get('sort') === null ? 'active' : '' ?>">
                    Дата
                    <div class="sort">
                        <a href="<?= $sort->createUrl('createdAtDate', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'createdAtDate' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-createdAtDate' || Yii::$app->request->get('sort') != 'createdAtDate' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="number <?= Yii::$app->request->get('sort') == 'orderNumber' || Yii::$app->request->get('sort') == '-orderNumber' ? 'active' : '' ?>">
                    Номер
                    <div class="sort">
                        <a href="<?= $sort->createUrl('orderNumber', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'orderNumber' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-orderNumber' || Yii::$app->request->get('sort') != 'orderNumber' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="position <?= Yii::$app->request->get('sort') == 'totalBox' || Yii::$app->request->get('sort') == '-totalBox' ? 'active' : '' ?>">
                    Позиция
                    <div class="sort">
                        <a href="<?= $sort->createUrl('totalBox', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'totalBox' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-totalBox' || Yii::$app->request->get('sort') != 'totalBox' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="price <?= Yii::$app->request->get('sort') == 'totalSum' || Yii::$app->request->get('sort') == '-totalSum' ? 'active' : '' ?>">
                    Сумма
                    <div class="sort">
                        <a href="<?= $sort->createUrl('totalSum', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'totalSum' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-totalSum' || Yii::$app->request->get('sort') != 'totalSum' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="status <?= Yii::$app->request->get('sort') == 'status' || Yii::$app->request->get('sort') == '-status' ? 'active' : '' ?>">
                    Статус
                    <div class="sort">
                        <a href="<?= $sort->createUrl('status', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'status' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-status' || Yii::$app->request->get('sort') != 'status' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="date-status <?= Yii::$app->request->get('sort') == 'updatedAtDate' || Yii::$app->request->get('sort') == '-updatedAtDate' ? 'active' : '' ?>">
                    Статус обновлен
                    <div class="sort">
                        <a href="<?= $sort->createUrl('updatedAtDate', true) ?>" class="sort-col"">
                        <span class="up <?= Yii::$app->request->get('sort') == 'updatedAtDate' ? 'active' : '' ?>"></span>
                        <span class="down <?= Yii::$app->request->get('sort') == '-updatedAtDate' || Yii::$app->request->get('sort') != 'updatedAtDate' ? 'active' : '' ?>"></span>
                        </a>
                    </div>
                </div>
                <div class="delete"></div>
            </div>
        </li>
        <?php if (!empty($provider->getModels())) : ?>
            <?php foreach ($provider->getModels() as $row) : ?>
                <li>
                    <div class="li-inner" id="<?= $row['uid'] ?>">
                        <div class="date"><?= Yii::$app->formatter->asDate($row['createdAtDate'], 'php:d.m.Y') ?></div>
                        <div class="number">
                            <div class="number__inner">
                                <a href="<?= Url::to([
                                    'order',
                                    'orderNumber' => $row['orderNumber']
                                ]) ?>"><?= $row['orderNumber'] ?></a>
                                <span class="<?= $row['documents']['exists'] == $searchModel::EXISTS_DOCUMENTS_NO ? 'no-active' : 'exists-doc' ?> show-lk-doc icon-doc"></i></span>
                            </div>
                        </div>
                        <div class="position"><?= $row['totalBox'] ?></div>
                        <div class="price"><?= Yii::$app->formatter->asCurrency($row['totalSum']) ?></div>
                        <div class="status"><i
                                    class="<?= $searchModel::$iconStatus[$row['status']] ?>"></i><?= $row['statusName'] ?>
                        </div>
                        <div class="date-status"><?= Yii::$app->formatter->asDatetime($row['updatedAtDateTime'],
                                'php:d.m.Y, H:i') ?></div>
                        <div class="delete"><span
                                    data-text="Подтвердите, пожалуйста, удаление позиции."
                                    class="delete-confirm <?= ($row['status'] == $searchModel::ORDER_CREATE) ? '' : 'no-active' ?> btn-delete icon-delete"></span>
                        </div>
                    </div>
                    <?php if ($row['documents']['exists'] == $searchModel::EXISTS_DOCUMENTS_YES) : ?>
                        <div class="lk-doc" data-id="<?= $row['uid'] ?>">
                            <ul class="lk-doc__list">
                                <?= $this->render('_documents', ['documents' => $documents]) ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
<div class="lk-list__bottom-nav">
    <?php //pagination ?>
    <?= $this->render('//layouts/partitials/pagination', ['pagination' => $provider->getPagination()]); ?>
    <a href="#" class="btn btn-info btn-add btn-new-order order-btn-one-size"><i
                class="icon-plus"></i>Создать новый заказ</a>
</div>
