<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 26.09.17
 * Time: 10:30
 */

namespace app\modules\lk\dto;

/**
 * Class FileDto
 * @package app\modules\lk\dto
 */
class FileDto extends BaseDto
{

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var int
     */
    protected $size = 0;

    /**
     * @var string
     */
    protected $extension = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $createdAt = '';

    /**
     * @var string
     */
    protected $updatedAt = '';

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
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension)
    {
        $this->extension = strtolower(preg_replace('#([^a-z]+)#i', '', $extension));
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        if ($this->path && file_exists($this->path)) {
            $mimes = [
                // images
                'png' => 'image/png',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'ico' => 'image/vnd.microsoft.icon',
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',
            ];
            $extension = pathinfo($this->path, PATHINFO_EXTENSION);


            return array_key_exists($extension, $mimes) ? $mimes[$extension] : 'text/plain';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return md5($this->getUid() . '-' . $this->getSize()) . '.' . $this->getExtension();
    }
}