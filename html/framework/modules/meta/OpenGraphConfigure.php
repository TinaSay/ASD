<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 10.07.18
 * Time: 16:06
 */

namespace app\modules\meta;

use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class OpenGraphConfigure
 *
 * @package app\modules\meta
 */
class OpenGraphConfigure extends Model implements ConfigurableInterface
{
    /**
     * @var string
     */
    public $title = 'Компания ASD';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
            [['title'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Open graph';
    }

    /**
     * @return array
     */
    public static function attributeTypes(): array
    {
        return [
            'title' => 'text',
        ];
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function populate(array $data): bool
    {
        return $this->load($data);
    }
}
