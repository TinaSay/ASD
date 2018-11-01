<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use app\modules\product\models\ProductSection;
use app\modules\product\models\ProductUsage;
use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class UsageSectionConfigure
 * @package app\modules\product\meta
 */
class UsageSectionConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = '{section.title} купить в компании ASD';
    /**
     * @var string
     */
    public $description = '{section.title} - в компании ASD. Каталог с описанием, условия продажи. Закажите на сайте или позвоните по телефону';
    /**
     * @var string
     */
    public $keywords = '{section.title} купить оптом заказать москва';

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
        return 'Категории раздела «Сферы применения»';
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
        $model = new ProductUsage();
        $section = new ProductSection();
        /** @see \app\modules\product\models\fake\UsageSection */
        return [
            'usage.title' => 'Сфера применения - ' . $model->getAttributeLabel('title'),
            'usage.name' => 'Сфера применения - ' . $model->getAttributeLabel('name'),
            'usage.description' => 'Сфера применения - ' . $model->getAttributeLabel('description'),
            'section.title' => 'Раздел - ' . $section->getAttributeLabel('title'),
        ];
    }
}