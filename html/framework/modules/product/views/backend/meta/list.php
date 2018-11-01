<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 02.05.18
 * Time: 20:24
 */

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $list \krok\configure\ConfigurableInterface[] */

$this->title = Yii::t('system', 'Configure');
$this->params['breadcrumbs'][] = $this->title;

$items = [];
// TODO: widget for this config
foreach ($list as $configurable) {
    if ($configurable instanceof \app\modules\product\meta\MetaTemplateInterface) {
        $items[] = [
            'label' => $configurable::label(),
            'content' => $this->render('_item', [
                'configurable' => $configurable,
            ]),
        ];
    }
}

$this->registerJs('
$(".attribute").on("click", function(e){
   e.preventDefault();
   var attribute = $(this).data("attribute"),
       $input = $(this).closest(".input-container").find("input:visible, textarea:visible");
       if($input.length){
          var value = $input.val();
          value += (value > "" ? " ": "") + "{" + attribute + "}";
          $input.val(value).focus();
       }
});
')
?>
<style>
    .tag {
        border-radius: 20px;
        box-sizing: border-box;
        border: 1px solid #66615B;
        background-color: transparent;
        font-size: 14px;
        font-weight: 600;
        padding: 5px 10px;
        color: #66615B;
        margin-right: 10px;
    }

    .input-container {
        margin-bottom: 40px;
    }
</style>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-content">

        <?= Tabs::widget([
            'items' => $items,
        ]) ?>

    </div>
</div>
