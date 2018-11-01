<?php

namespace app\modules\product\dto;

use yii\base\Arrayable;

/**
 * Class ParamDto
 *
 * @package app\modules\product\dto
 */
class ParamDto implements Arrayable
{

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $value = '';

    /**
     * ParamDto constructor.
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = trim($title, "\r\n\s\t\0\:");
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
     * @return array
     */
    public function fields()
    {
        return ['title', 'value'];
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [];
    }

    /**
     * @param array $fields
     * @param array $expand
     * @param bool $recursive
     *
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'title' => $this->getTitle(),
            'value' => $this->getValue(),
        ];
    }
}