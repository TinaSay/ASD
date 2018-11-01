<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 30.01.18
 * Time: 10:23
 */

namespace app\modules\product\dto;

/**
 * Class BaseDto
 *
 * @package app\modules\product\dto
 */
class BaseDto
{
    /**
     * @var string
     */
    protected $uid = '';

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var int
     */
    protected $deleted = 0;

    /**
     * BaseDto constructor.
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
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid !== '00000000-0000-0000-0000-000000000000' ? $this->uid : '';
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid): void
    {
        $this->uid = $uid;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getDeleted(): int
    {
        return $this->deleted;
    }

    /**
     * @param int $deleted
     */
    public function setDeleted(int $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->deleted > 0;
    }
}