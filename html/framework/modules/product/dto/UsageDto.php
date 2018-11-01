<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 29.01.18
 * Time: 11:46
 */

namespace app\modules\product\dto;

/**
 * Class UsageDto
 *
 * @package app\modules\product\dto
 */
class UsageDto extends BaseDto
{

    /**
     * @var FileDto|null
     */
    protected $icon;

    /**
     * @var int
     */
    protected $position = 0;

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

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}