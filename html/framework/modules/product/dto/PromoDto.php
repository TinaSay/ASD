<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 29.01.18
 * Time: 11:46
 */

namespace app\modules\product\dto;

/**
 * Class PromoDto
 *
 * @package app\modules\product\dto
 */
class PromoDto extends BaseDto
{

    /**
     * @var null|FileDto
     */
    protected $icon;

    /**
     * @var string
     */
    protected $color = '';

    /**
     * @var array
     */
    protected $products = [];

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @return FileDto
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
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @param string $uid
     */
    public function addProduct(string $uid)
    {
        if ($uid !== '00000000-0000-0000-0000-000000000000') {
            array_push($this->products, $uid);
        }
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