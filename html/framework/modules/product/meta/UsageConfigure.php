<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use app\modules\product\models\ProductUsage;
use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class UsageConfigure
 * @package app\modules\product\meta
 */
class UsageConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = 'Купить товары {title} в компании ASD';
    /**
     * @var string
     */
    public $description = 'Цены на товары {title} в каталоге компании ASD. Закажите на сайте или позвоните по телефону';
    /**
     * @var string
     */
    public $keywords = '{title} товары цена купить оптом заказать москва';

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
        return 'Разделы «Сферы применения»';
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
        return [
            'title' => $model->getAttributeLabel('title'),
            'name' => $model->getAttributeLabel('name'),
            'description' => $model->getAttributeLabel('description'),
        ];
    }
}