<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 15.11.15
 * Time: 20:51
 */

namespace app\widgets\pagination;

use yii\helpers\Html;

/**
 * Class LinkPager
 *
 * @package app\widgets\pagination
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     *
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     *
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        Html::addCssClass($linkOptions, $class === null ? $this->linkOptions : $class);

        $linkOptions['data-page'] = $page;

        if ($disabled) {
            Html::addCssClass($linkOptions, $this->disabledPageCssClass);
        }

        return $active ? Html::tag('span', $label, [
            'class' => $this->activePageCssClass,
        ]) : Html::a($label, $this->pagination->createUrl($page), $linkOptions);
    }
}
