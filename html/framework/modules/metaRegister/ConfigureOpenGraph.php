<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 26.06.18
 * Time: 10:20
 */

namespace app\modules\metaRegister;

use app\modules\metaRegister\interfaces\ConfigurableInterface;
use yii\base\Model;

/**
 * Class ConfigureOpenGraph
 *
 * @package app\modules\metaRegister
 */
class ConfigureOpenGraph extends Model implements ConfigurableInterface
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $locale;

    /**
     * @var string
     */
    public $siteName;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['title', 'type', 'description', 'locale', 'siteName'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'заголовок',
            'type' => 'тип',
            'description' => 'описание',
            'locale' => 'язык',
            'siteName' => 'название сайта',
        ];
    }

    /**
     * @return array
     */
    public function metaTags(): array
    {
        return [
            'title' => 'text',
            'type' => 'text',
            'description' => 'text',
            'locale' => 'text',
            'siteName' => 'text',
        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'openGraph';
    }
}
