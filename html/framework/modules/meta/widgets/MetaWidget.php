<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 11.07.18
 * Time: 15:49
 */

namespace app\modules\meta\widgets;

use krok\meta\MetaInterface;
use tina\metatag\models\Metatag;
use yii\base\Model;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/**
 * Class MetaWidget
 *
 * @package app\modules\meta\widgets
 */
class MetaWidget extends Widget
{
    /**
     * @var Metatag
     */
    public $metatag;

    /**
     * @var Model
     */
    public $model;

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var string
     */
    public $openGraphView = '_opengraph';

    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * MetaWidget constructor.
     *
     * @param MetaInterface $meta
     * @param array $config
     */
    public function __construct(MetaInterface $meta, array $config = [])
    {
        parent::__construct($config);
        $this->meta = $meta;
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('index', [
            'form' => $this->form,
            'model' => $this->model,
            'metatag' => $this->metatag,
            'list' => $this->getList(),
        ]);
    }

    /**
     * @return array
     */
    protected function getList(): array
    {
        $list = [];

        $adapters = $this->meta->get($this->model);

        foreach ($adapters as $adapter) {
            $list[] = [
                'content' => $this->render($this->openGraphView, [
                    'form' => $this->form,
                    'adapter' => $adapter,
                ]),
            ];
        }

        return $list;
    }
}
