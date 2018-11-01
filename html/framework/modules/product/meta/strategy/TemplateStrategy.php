<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 11:21
 */

namespace app\modules\product\meta\strategy;

use krok\meta\strategies\StrategyInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class TemplateStrategy
 * @package app\modules\product\meta\strategy
 */
class TemplateStrategy implements StrategyInterface
{
    /**
     * @var array - [attribute => template]
     */
    public $compose = [];

    /**
     * @param Model $model
     * @param array $tags
     *
     * @return array
     */
    public function apply(Model $model, array $tags): array
    {
        // prevent getting unknown property
        $model = $model->toArray();
        $compose = array_map(function ($row) use ($model) {
            return (string)preg_replace_callback('#\{([\.\w]+)\}#', function ($matches) use ($model) {
                return ArrayHelper::getValue($model, $matches[1], '');
            }, $row);
        }, $this->compose);

        return array_diff(array_merge($tags, $compose), ['']);
    }
}