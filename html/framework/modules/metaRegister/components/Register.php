<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 25.06.18
 * Time: 15:51
 */

namespace app\modules\metaRegister\components;

use app\modules\metaRegister\models\MetaData;
use Yii;
use yii\di\Instance;
use yii\web\View;

/**
 * Class Register
 *
 * @package app\modules\metaRegister\components
 */
class Register
{
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $image;

    /**
     * @var View
     */
    protected $view;

    /**
     * @param $meta
     * @param string $view
     */
    public function metaComposer($meta, string $view = 'view')
    {
        $metaData = MetaData::find()->where(['metaId' => $meta->id])->all();

        $this->view = Instance::ensure($view, View::class);

        if (is_callable($this->url)) {
            $this->url = call_user_func($this->url);
        } else {
            $this->url = 'http://asd.dev-vps.ru/';
        }

        if (is_callable($this->image)) {
            $this->image = call_user_func($this->image);
        } else {
            $this->image = Yii::$app->request->getBaseUrl() . '/static/asd/img/logo2.svg';
        }

        $this->view->registerMetaTag([
            'property' => 'og:' . 'url',
            'content' => $this->url,
        ]);

        $this->view->registerMetaTag([
            'property' => 'og:' . 'image',
            'content' => $this->image,
        ]);

        foreach ($metaData as $metaTag) {
            $this->view->registerMetaTag([
                'property' => 'og:' . $metaTag->name,
                'content' => $metaTag->value,
            ]);
        }
    }
}
