<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 10.07.18
 * Time: 16:54
 */

namespace app\widgets\back;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;

/**
 * Class BackBtnWidget
 * @package app\widgets\back
 */
class BackBtnWidget extends Widget
{
    /**
     * @var string
     */
    public $defaultUrl;

    /**
     * @var string
     */
    public $text = 'Вернуться к списку';

    /**
     * @var null|string
     */
    protected $backUrl;

    /**
     *
     */
    public function init()
    {
        parent::init();

        if (!$this->defaultUrl) {
            throw new InvalidArgumentException('Property "defaultUrl" must be set');
        }

        $return_url = Yii::$app->request->referrer;
        if (preg_match('#' . preg_quote(Yii::$app->request->hostName) . '#i', $return_url)) {
            $this->backUrl = preg_replace('#https?\:\/\/' . preg_quote(Yii::$app->request->hostName) . '#i', '',
                $return_url);
        };
    }


    public function run()
    {
        return $this->backUrl ? $this->render('back', [
            'url' => $this->backUrl,
        ]) : $this->render('back-to-list', [
            'url' => $this->defaultUrl,
            'text' => $this->text,
        ]);
    }

}