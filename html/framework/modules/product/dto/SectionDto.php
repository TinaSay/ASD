<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 29.01.18
 * Time: 11:46
 */

namespace app\modules\product\dto;

/**
 * Class SectionDto
 *
 * @package app\modules\product\dto
 */
class SectionDto extends BaseDto
{

    /**
     * @var string|null
     */
    protected $parentUid;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var BaseDto[]
     */
    protected $brands = [];

    /**
     * @return null|string
     */
    public function getParentUid(): ?string
    {
        return $this->parentUid !== '00000000-0000-0000-0000-000000000000' ? $this->parentUid : null;
    }

    /**
     * @param null|string $parentUid
     */
    public function setParentUid(string $parentUid): void
    {
        $this->parentUid = $parentUid;
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

    /**
     * @return BaseDto[]
     */
    public function getBrands(): array
    {
        return $this->brands;
    }

    /**
     * @param BaseDto[] $brands
     */
    public function setBrands(array $brands): void
    {
        foreach ($brands as $brand) {
            $this->addBrand($brand);
        }
    }

    /**
     * @param BaseDto $dto
     */
    public function addBrand(BaseDto $dto)
    {
        array_push($this->brands, $dto);
    }
}