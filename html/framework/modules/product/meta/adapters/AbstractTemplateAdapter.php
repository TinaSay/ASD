<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 12.07.18
 * Time: 11:20
 */

namespace app\modules\product\meta\adapters;

use app\modules\product\meta\MetaTemplateInterface;
use app\modules\product\meta\strategy\TemplateStrategy;
use krok\configure\ConfigurableInterface;
use krok\configure\ConfigureInterface;
use krok\meta\adapters\AdapterInterface;
use krok\meta\adapters\MetaAdapter;
use krok\meta\strategies\StrategyInterface;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\di\Instance;
use yii\web\View;

/**
 * Class AbstractTemplateAdapter
 * @package app\modules\product\meta\adapters
 */
abstract class AbstractTemplateAdapter extends MetaAdapter implements AdapterInterface
{
    const TITLE_TAG = 'title';

    /**
     * @var Model|MetaTemplateInterface|ConfigurableInterface
     */
    public $configurable;

    /**
     * MetaTemplateAdapter constructor.
     * @param ConfigureInterface $configure
     * @param array $config
     */
    public function __construct(ConfigureInterface $configure, array $config = [])
    {
        parent::__construct($config);

        $this->configurable = $configure->get(static::getConfigure());

        if (!$this->configurable instanceof MetaTemplateInterface) {
            throw new InvalidArgumentException('Class ' . get_class($this->configurable) . ' must implements ' . MetaTemplateInterface::class);
        }
    }

    abstract static protected function getConfigure(): string;

    /**
     * @param string $configurable
     */
    public function setConfigure(string $configurable)
    {
        /** @var ConfigureInterface $configure */
        $configure = Yii::createObject(ConfigureInterface::class);
        $this->configurable = $configure->get($configurable);

        if (!$this->configurable instanceof MetaTemplateInterface) {
            throw new InvalidArgumentException('Class ' . get_class($this->configurable) . ' must implements ' . MetaTemplateInterface::class);
        }
    }

    /**
     * @return StrategyInterface|TemplateStrategy
     */
    public function getStrategy(): StrategyInterface
    {
        $this->strategy = [
            'class' => TemplateStrategy::class,
            'compose' => $this->configurable->getAttributes(),
        ];

        /** @var StrategyInterface $strategy */
        $strategy = Instance::ensure($this->strategy, StrategyInterface::class);

        return $strategy;
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'title' => 'title',
            'description' => 'description',
            'keywords' => 'keywords',
        ];
    }

    /**
     * @param Model $model
     * @param View $view
     *
     * @return bool
     */
    public function register(Model $model, View $view): bool
    {
        $tags = $this->getStrategy()->apply($model, $this->toArray());

        foreach ($tags as $name => $content) {
            if ($name == self::TITLE_TAG) {
                $view->title = $content;
                continue;
            }
            $view->registerMetaTag([
                'name' => $name,
                'content' => $content,
            ]);
        }

        return true;
    }
}