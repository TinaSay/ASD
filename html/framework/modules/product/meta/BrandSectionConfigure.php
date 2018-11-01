<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use app\modules\product\models\ProductBrand;
use app\modules\product\models\ProductSection;
use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class SectionConfigure
 * @package app\modules\product\meta
 */
class BrandSectionConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = 'Купить {section.title} {brand.title} в компании ASD';
    /**
     * @var string
     */
    public $description = '{section.title} - купить по выгодной цене в компании ASD. Закажите на сайте или позвоните по телефону';
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
        return 'Список товары бренда';
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
        $model = new ProductSection();
        $brand = new ProductBrand();
        /** @see \app\modules\product\models\fake\BrandSection */
        return [
            'section.title' => 'Раздел - ' . $model->getAttributeLabel('title'),
            'brand.title' => 'Производитель - ' . $brand->getAttributeLabel('title'),
            'brand.description' => 'Производитель - ' . $brand->getAttributeLabel('description'),
        ];
    }
}