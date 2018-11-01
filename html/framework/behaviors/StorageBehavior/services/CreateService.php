<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 02.08.17
 * Time: 15:41
 */

namespace app\behaviors\StorageBehavior\services;

use krok\storage\File;
use krok\storage\interfaces\StorageInterface;
use krok\storage\models\Storage;
use Yii;
use yii\web\UploadedFile;


/**
 * Class CreateService
 *
 * @package krok\storage\services
 */
class CreateService
{
    /**
     * @var StorageInterface
     */
    protected $model;
    /**
     * @var string
     */
    protected $attribute;
    /**
     * @var File
     */
    protected $file;

    /**
     * @var UploadedFile
     */
    protected $modelFile;

    /**
     * CreateService constructor.
     *
     * @param StorageInterface $model
     * @param string $attribute
     * @param File $file
     * @param UploadedFile $modelFile
     */
    public function __construct(StorageInterface $model, string $attribute, File $file, UploadedFile $modelFile)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->file = $file;
        $this->modelFile = $modelFile;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $storage = Yii::createObject(Storage::class);
        $storage->model = $this->model->getModel();
        $storage->recordId = $this->model->getRecordId();
        $storage->attribute = $this->attribute;
        $storage->title = $this->modelFile->name;
        $storage->hint = $this->model->getHint();
        $storage->src = $this->file->getFile();
        $storage->mime = $this->file->getMimeType();
        $storage->size = $this->file->getSize();

        return $storage->save();
    }
}
