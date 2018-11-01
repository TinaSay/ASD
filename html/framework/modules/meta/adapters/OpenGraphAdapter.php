<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 10.07.18
 * Time: 16:37
 */

namespace app\modules\meta\adapters;

use app\modules\meta\OpenGraphConfigure;
use krok\configure\ConfigureInterface;
use krok\meta\adapters\AbstractAdapter;
use krok\meta\strategies\ComposeStrategy;
use krok\meta\strategies\StrategyInterface;
use krok\meta\types\DropDownType;
use Yii;
use yii\base\Model;
use yii\web\View;

/**
 * Class OpenGraphAdapter
 *
 * @package app\modules\meta\adapters
 */
class OpenGraphAdapter extends AbstractAdapter
{
    const TYPE_ARTICLE = 'article';
    const TYPE_WEBSITE = 'website';
    const TYPE_PROFILE = 'profile';
    const TYPE_BOOK = 'book';

    const LOCALE_RU = 'ru_RU';
    const LOCALE_EN = 'en_US';

    const USE_TITLE_NO = 0;
    const USE_TITLE_YES = 1;

    /**
     * @var int
     */
    public $useTitle = self::USE_TITLE_YES;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $type = self::TYPE_ARTICLE;

    /**
     * @var string
     */
    public $locale = self::LOCALE_RU;

    /**
     * @var string
     */
    public $siteName;

    /**
     * @var OpenGraphConfigure
     */
    protected $configurable;

    /**
     * OpenGraphAdapter constructor.
     *
     * @param ConfigureInterface $configure
     * @param array $config
     */
    public function __construct(ConfigureInterface $configure, array $config = [])
    {
        parent::__construct($config);
        $this->configurable = $configure->get(OpenGraphConfigure::class);
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'og:title' => 'title',
            'og:description' => 'description',
            'og:type' => 'type',
            'og:locale' => 'locale',
            'og:site_name' => 'siteName',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['useTitle'], 'integer'],
            [['title', 'description', 'type', 'locale'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'useTitle' => 'Использовать заголовок страницы',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип',
            'locale' => 'Язык',
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Open Graph';
    }

    /**
     * @return array
     */
    public static function attributeTypes(): array
    {
        return [
            'useTitle' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getUseTitleList(),
                ],
            ],
            'title' => 'text',
            'description' => 'text',
            'type' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getTypes(),
                ],
            ],
            'locale' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getLocales(),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return [
            static::TYPE_ARTICLE => 'Публикация',
            static::TYPE_WEBSITE => 'Вебсайт',
            static::TYPE_PROFILE => 'Профайл',
            static::TYPE_BOOK => 'Книга',
        ];
    }

    /**
     * @return array
     */
    public static function getLocales(): array
    {
        return [
            static::LOCALE_RU => 'Русский',
            static::LOCALE_EN => 'English',
        ];
    }

    /**
     * @return array
     */
    public static function getUseTitleList(): array
    {
        return [
            static::USE_TITLE_YES => 'Да',
            static::USE_TITLE_NO => 'Нет',
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
     * @param Model $model
     * @param View $view
     *
     * @return bool
     */
    public function register(Model $model, View $view): bool
    {
        $this->siteName = $this->configurable->title;

        $tags = $this->getStrategy()->apply($model, $this->toArray());

        $this->registerSocialTitle($tags);

        foreach ($tags as $name => $content) {
            $view->registerMetaTag([
                'property' => $name,
                'content' => $content,
            ]);
        }

        return true;
    }

    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        if ($this->useTitle == static::USE_TITLE_YES) {
            $this->strategy = [
                'class' => ComposeStrategy::class,
                'compose' => [
                    'og:title' => 'title',
                ],
            ];
        }

        return parent::getStrategy();
    }

    /**
     * @param array $tags
     */
    protected function registerSocialTitle(array $tags)
    {
        Yii::$app->params['title'] = $tags['og:title'];
    }
}
