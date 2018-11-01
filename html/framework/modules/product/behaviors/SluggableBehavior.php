<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 01.05.18
 * Time: 14:41
 */

namespace app\modules\product\behaviors;

use yii\behaviors\SluggableBehavior as BaseBehavior;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * Class SluggableBehavior
 *
 * @package app\modules\product\behaviors
 */
class SluggableBehavior extends BaseBehavior
{

    /**
     * @var string the attribute that will receive the slug value
     */
    public $slugAttribute = 'alias';

    /**
     * @var string|array|null the attribute or list of attributes whose value will be converted into a slug
     * or `null` meaning that the `$value` property will be used to generate a slug.
     */
    public $attribute = 'title';

    /**
     * @var bool whether to ensure generated slug value to be unique among owner class records.
     * If enabled behavior will validate slug uniqueness automatically. If validation fails it will attempt
     * generating unique slug value from based one until success.
     */
    public $ensureUnique = true;

    /**
     * This method is called by [[getValue]] to generate the slug.
     * You may override it to customize slug generation.
     * The default implementation calls [[\yii\helpers\Inflector::slug()]] on the input strings
     * concatenated by dashes (`-`).
     *
     * @param array $slugParts an array of strings that should be concatenated and converted to generate the slug value.
     *
     * @return string the conversion result.
     */
    protected function generateSlug($slugParts)
    {
        $slug = Inflector::slug(implode('-', $slugParts));
        $slug = StringHelper::truncate($slug, 127, '');

        return preg_replace("#-h-#", '-x-', $slug);
    }
}