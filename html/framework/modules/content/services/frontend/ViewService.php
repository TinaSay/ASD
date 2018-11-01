<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 18.04.18
 * Time: 11:33
 */

namespace app\modules\content\services\frontend;

use app\modules\content\dto\frontend\ContentDto;
use app\modules\content\models\Content;
use krok\meta\MetaInterface;
use tina\metatag\components\Metatag;
use Yii;
use yii\caching\TagDependency;
use yii\web\NotFoundHttpException;

/**
 * Class ViewService
 *
 * @package app\modules\content\services\frontend
 */
class ViewService extends \krok\content\services\frontend\ViewService
{
    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @var Metatag
     */
    protected $metatag;

    /**
     * ViewService constructor.
     *
     * @param string $alias
     * @param Content $model
     * @param MetaInterface $meta
     * @param Metatag $metatag
     */
    public function __construct(string $alias, Content $model, MetaInterface $meta, Metatag $metatag)
    {
        $this->meta = $meta;
        $this->metatag = $metatag;
        parent::__construct($alias, $model);
    }

    /**
     * @return ContentDto|object
     * @throws NotFoundHttpException
     */
    public function execute()
    {
        $key = [
            __CLASS__,
            __FILE__,
            __LINE__,
            $this->alias,
            Yii::$app->language,
        ];

        $dependency = new TagDependency([
            'tags' => [
                Content::class,
            ],
        ]);

        $model = Yii::$app->getCache()->get($key);

        if ($model === false) {
            $model = $this->model::find()->byAlias($this->alias)->hidden()->language()->one();
            Yii::$app->getCache()->set($key, $model, 1 * 60 * 60, $dependency);
        }

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->meta->register(clone $model);
        $this->metatag->metatagComposer($model->meta, $model->title, $model->alias === 'index');

        return Yii::createObject(ContentDto::class, [$model]);
    }
}
