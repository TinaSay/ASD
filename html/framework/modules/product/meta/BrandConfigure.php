<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use app\modules\product\models\ProductBrand;
use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class BrandConfigure
 * @package app\modules\product\meta
 */
class BrandConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = 'Купить товары {title} - каталог товаров {title} с ценами, описанием';
    /**
     * @var string
     */
    public $description = 'Компания ASD предлагает товары {title}. Условия покупки, доставки, описание и цены на товары {title} для крупных и мелких риелтеров.';
    /**
     * @var string
     */
    public $keywords = 'купить товары оптом москва {title}';

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
        return 'Страницы брендов';
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
        $model = new ProductBrand();
        return [
            'title' => $model->getAttributeLabel('title'),
            'description' => $model->getAttributeLabel('description'),
        ];
    }
}