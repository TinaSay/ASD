<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class UsageMainConfigure
 * @package app\modules\product\meta
 */
class UsageMainConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = 'Товары производства группы компаний ASD';
    /**
     * @var string
     */
    public $description = 'Товары производства группы компаний ASD – упаковочные материалы, товары для быта, ремонта и отдыха';
    /**
     * @var string
     */
    public $keywords = '';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'description', 'keywords'], 'string'],
            [['title'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок страницы',
            'description' => 'Описание страницы',
            'keywords' => 'Ключевые слова',
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Страница Сферы применения';
    }

    /**
     * @return array
     */
    public static function attributeTypes(): array
    {
        return [
            'title' => 'text',
            'description' => 'text',
            'keywords' => 'text',
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

    /**
     * @return array
     */
    public function getModelTemplateAttributes(): array
    {
        return [];
    }
}