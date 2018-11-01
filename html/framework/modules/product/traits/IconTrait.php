<?php
/**
 * Created by PhpStorm.
 * User: elfuvo
 * Date: 05.02.18
 * Time: 16:22
 */

namespace app\modules\product\traits;

use krok\storage\dto\StorageDto;
use Yii;
use yii\web\UploadedFile;

/**
 * Trait IconTrait
 *
 * @package app\modules\product\traits
 */
trait IconTrait
{
    /**
     * @var UploadedFile|StorageDto
     */
    protected $icon;

    /**
     * @return StorageDto|UploadedFile
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * StorageInterface realization
     *
     * @return string Model className
     */
    public function getModel(): string
    {
        return static::class;
    }

    /**
     * @return int
     */
    public function getRecordId(): int
    {
        return $this->id;
    }

    /**
     * StorageInterface realization
     *
     * @return string File title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * StorageInterface realization
     *
     * @return string File hint
     */
    public function getHint(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getIconUrl()
    {

        if (!$this->icon) {
            return '';
        }
        $filesystem = Yii::createObject(\League\Flysystem\FilesystemInterface::class);

        return $filesystem->getDownloadUrl($this->icon->getSrc());
    }

    /**
     * check image mime
     *
     * @param $attribute
     * @param $params
     *
     * @return bool;
     */
    public function checkMimeType($attribute, $params)
    {
        $mimeTypes = $params['mimeTypes'] ?? ['image/png', 'image/jpeg', 'image/svg+xml'];

        if (isset($params['skipOnEmpty']) && $params['skipOnEmpty'] && !$this->getIcon()) {
            return true;
        }
        if ($file = $this->getIcon()) {
            $mime = '';
            if ($file instanceof UploadedFile) {
                $mime = $file->getExtension() == 'svg' ? 'image/svg+xml' : $file->type;
            } elseif ($file instanceof StorageDto) {
                $mime = $file->getMime();
            }

            if (!in_array($mime, $mimeTypes)) {
                $this->addError($attribute,
                    Yii::t('yii', 'Only files with these MIME types are allowed: {mimeTypes}.',
                        ['mimeTypes' => implode(', ', $mimeTypes)])
                );

                return false;
            }

            return true;
        } elseif (!isset($params['skipOnEmpty']) || $params['skipOnEmpty'] !== true) {
            $this->addError($attribute, Yii::t('yii', 'Please upload a file.'));

            return false;
        }

        return false;
    }
}