<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 26.01.18
 * Time: 17:52
 */

namespace app\modules\product\dto;

/**
 * Class BrandDto
 *
 * @package app\modules\product\dto
 */
class BrandDto extends BaseDto
{
    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $text = '';

    /**
     * @var FileDto|null
     */
    protected $logo;

    /**
     * @var FileDto|null
     */
    protected $presentation;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }


    /**
     * @return FileDto
     */
    public function getLogo(): ?FileDto
    {
        return $this->logo;
    }

    /**
     * @param FileDto $logo
     */
    public function setLogo(FileDto $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return FileDto
     */
    public function getPresentation(): ?FileDto
    {
        return $this->presentation;
    }

    /**
     * @param FileDto $presentation
     */
    public function setPresentation(FileDto $presentation): void
    {
        $this->presentation = $presentation;
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