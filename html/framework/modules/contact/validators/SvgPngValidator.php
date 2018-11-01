<?php


namespace app\modules\contact\validators;

use yii;
use yii\validators\ImageValidator;

/**
 * ImageValidator verifies if an attribute is receiving a valid image.
 *
 * @author Taras Gudz <gudz.taras@gmail.com>
 * @since 2.0
 */
class SvgPngValidator extends ImageValidator
{

    public $notSvgPngImage;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->notSvgPngImage === null) {
            $this->notSvgPngImage = Yii::t('yii', 'The file "{file}" is not an PNG or SVG image.');
        }

    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $result = parent::validateValue($value);
        return empty($result) ? $this->validateImage($value) : $result;
    }

    /**
     * Validates an image file.
     * @param UploadedFile $image uploaded file passed to check against a set of rules
     * @return array|null the error message and the parameters to be inserted into the error message.
     * Null should be returned if the data is valid.
     */
    protected function validateImage($image)
    {
        if ($image->extension == 'svg') {
            if ($image->type != 'image/svg+xml') {
                return [$this->notImage, ['file' => $image->name]];
            }
        } elseif ($image->extension == 'png') {

            if (false === ($imageInfo = getimagesize($image->tempName))) {
                return [$this->notImage, ['file' => $image->name]];
            }

            list($width, $height) = $imageInfo;

            if ($width == 0 || $height == 0) {
                return [$this->notImage, ['file' => $image->name]];
            }

            if ($this->minWidth !== null && $width < $this->minWidth) {
                return [$this->underWidth, ['file' => $image->name, 'limit' => $this->minWidth]];
            }

            if ($this->minHeight !== null && $height < $this->minHeight) {
                return [$this->underHeight, ['file' => $image->name, 'limit' => $this->minHeight]];
            }

            if ($this->maxWidth !== null && $width > $this->maxWidth) {
                return [$this->overWidth, ['file' => $image->name, 'limit' => $this->maxWidth]];
            }

            if ($this->maxHeight !== null && $height > $this->maxHeight) {
                return [$this->overHeight, ['file' => $image->name, 'limit' => $this->maxHeight]];
            }
        } else {

        }


        return null;
    }


}
