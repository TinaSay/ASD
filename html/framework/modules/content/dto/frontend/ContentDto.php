<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 18.04.18
 * Time: 11:06
 */

namespace app\modules\content\dto\frontend;

use app\modules\content\models\Content;
use tina\metatag\models\Metatag;

/**
 * Class ContentDto
 *
 * @package app\modules\content\dto\frontend
 */
class ContentDto extends \krok\content\dto\frontend\ContentDto
{
    /**
     * @var Content
     */
    protected $model;

    /**
     * @return null|Metatag
     */
    public function getMeta(): ?Metatag
    {
        return $this->model->meta;
    }

    public function getBannerPosition(): ?int
    {
        return $this->model->bannerPosition;
    }

    public function getBannerColor(): ?string
    {
        return $this->model->bannerColor;
    }

    public function getProductSet(): ?int
    {
        return $this->model->productSet;
    }

    public function getRenderForm(): ?int
    {
        return $this->model->renderForm;
    }

    public function getSkedIds(): ?array
    {
        return $this->model->getSkedIds();
    }

    public function getBannerIds(): ?array
    {
        return $this->model->getBannerIds();
    }

}
