<?php

namespace app\modules\product\dto;

/**
 * Class ProductSetItemDto
 *
 * @package app\modules\product\dto
 */
class ProductSetItemDto
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $productUid = '';

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * ProductSetItemDto constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $param => $value) {
            if (method_exists($this, 'set' . $param)) {
                call_user_func([$this, 'set' . $param], $value);
            }
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getProductUid(): string
    {
        return $this->productUid !== '00000000-0000-0000-0000-000000000000' ? $this->productUid : '';
    }

    /**
     * @param string $productUid
     */
    public function setProductUid(string $productUid): void
    {
        $this->productUid = $productUid;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

}