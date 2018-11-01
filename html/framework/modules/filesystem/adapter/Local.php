<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 12.06.18
 * Time: 14:45
 */

namespace app\modules\filesystem\adapter;

use Finfo;
use League\Flysystem\Util\MimeType;

/**
 * Class Local
 *
 * @package app\modules\filesystem\adapter
 */
class Local extends \League\Flysystem\Adapter\Local
{
    /**
     * @param $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        $location = $this->applyPathPrefix($path);
        $finfo = new Finfo(FILEINFO_MIME_TYPE);
        $mimetype = $finfo->file($location);

        if (in_array($mimetype, ['application/octet-stream', 'inode/x-empty', 'text/html'])) {
            $mimetype = MimeType::detectByFilename($location);
        }

        return ['path' => $path, 'type' => 'file', 'mimetype' => $mimetype];
    }
}
