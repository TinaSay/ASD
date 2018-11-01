<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 10.07.18
 * Time: 16:15
 */

namespace app\modules\meta;

use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class MetaConfigure
 *
 * @package app\modules\meta
 */
class MetaConfigure extends Model implements ConfigurableInterface
{
    /**
     * @var string
     */
    public $title = 'ASD';

    /**
     * @var string
     */
    public $keywords;

    /**
     * @var string
     */
    public $description;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'keywords', 'description'], 'string'],
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
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Метаданные';
    }

    /**
     * @return array
     */
    public static function attributeTypes(): array
    {
        return [
            'title' => 'text',
            'keywords' => 'text',
            'description' => 'text',
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
