<?php

use yii\helpers\Url;
use yii\web\JsExpression;

/** @var $this \yii\web\View */
/** @var $rating \app\modules\rating\models\Rating */
/** @var $avgRating integer */
?>


<!--
    скрипт (ниже на странице инициализация) генерит сюда инпут и спаны,
    по дизайну после того, как голос учтен, кнопка 'голосовать' пропадает
    Можно к форме добавить класс .send, у кнопки появится дисплей нон
 -->

<form class="change rate-form<?= $rating->isNewRecord ? '' : ' send' ?>"
      action="<?= Url::to('/rating/default/rating') ?>">
    <div class="rate-form__caption"><?= ($rating->sessionId) ? 'Ваша оценка' : 'Оцените материал' ?></div>
    <div class="rate_row"></div>
    <input class="get_module" value="<?= $rating->module ?>" type="hidden">
    <input class="get_record_id" value="<?= $rating->record_id ?>" type="hidden">
    <div class="rate_num"><span class="num"><?= $avgRating ?></span>/10</div>
    <!--<button class="btn-rate btn btn-block btn-primary">Голосовать</button>-->
</form>


<?php

$js = new JsExpression("
    var rateDisabled = false;
    $('.rate_row').starwarsjs({
        target: '.rate_row',
        stars: 10,
        default_stars: $avgRating,
        on_select : function(data){ rateAdvice(); }
    }); 
    $('.rate_row .rate_star').hover(function () {
        if(rateDisabled) { 
            return false; 
        }
        var c = $('.rate_row').find('.over').length;
        $('div.rate_num > .num').text(c)
    },function () {
        if(rateDisabled) { 
            return false; 
        }
        $('div.rate_num > .num').text($avgRating)
    });
");
$this->registerJs($js);
?>
