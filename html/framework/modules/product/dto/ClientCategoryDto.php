<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 30.01.18
 * Time: 10:21
 */

namespace app\modules\product\dto;

/**
 * Class ClientCategoryDto
 *
 * @package app\modules\product\dto
 */
class ClientCategoryDto extends BaseDto
{
    /**
     * @var FileDto|null
     */
    protected $icon;

    /**
     * @return FileDto|null
     */
    public function getIcon(): ?FileDto
    {
        return $this->icon;
    }

    /**
     * @param FileDto $icon
     */
    public function setIcon(FileDto $icon): void
    {
        $this->icon = $icon;
    }
}