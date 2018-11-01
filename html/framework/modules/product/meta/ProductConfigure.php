<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 9:50
 */

namespace app\modules\product\meta;

use app\modules\product\models\Product;
use krok\configure\ConfigurableInterface;
use yii\base\Model;

/**
 * Class ProductConfigure
 * @package app\modules\product\meta
 */
class ProductConfigure extends Model implements ConfigurableInterface, MetaTemplateInterface
{
    /**
     * @var string
     */
    public $title = 'Купить {title}, {article} в компании ASD';
    /**
     * @var string
     */
    public $description = '{title}, {article} -  в каталоге компании ASD. Закажите на сайте или позвоните по телефону';
    /**
     * @var string
     */
    public $keywords = '{title} купить оптом заказать москва';

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
        return 'Карточки товаров';
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
        $model = new Product();
        return [
            'article' => $model->getAttributeLabel('article'),
            'title' => $model->getAttributeLabel('title'),
            'printableTitle' => $model->getAttributeLabel('printableTitle'),
            'description' => $model->getAttributeLabel('description'),
            'advantages' => $model->getAttributeLabel('advantages'),
        ];
    }
}