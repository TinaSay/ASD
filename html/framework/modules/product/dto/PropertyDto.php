<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 30.01.18
 * Time: 16:00
 */

namespace app\modules\product\dto;

/**
 * Class PropertyDto
 *
 * @package app\modules\product\dto
 */
class PropertyDto
{
    /**
     * fixed property list
     *
     * @var array
     */
    public static $staticProperties = [
        'Weight' => 'Вес',
        'BoxQuantity' => 'Единица для отчетов',
        'BestBefore' => 'Срок хранения',
        'BoxLenght' => 'Длина коробки',
        'BoxWidth' => 'Ширина коробки',
        'BoxHeight' => 'Высота коробки',
        'Material' => 'Состав, материал',
    ];

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $code = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @var null|string
     */
    protected $unit;

    /**
     * PropertyDto constructor.
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim($title, "\s\r\n\t\0\:");
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(?string $unit): void
    {
        $this->unit = $unit;
    }

}