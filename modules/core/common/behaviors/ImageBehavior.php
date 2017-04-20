<?php

namespace app\modules\core\common\behaviors;

use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class ImageBehavior extends Behavior
{
    /**
     * @var ActiveRecord the owner of this behavior
     */
    public $owner;

    // Model image attributes
    public $attributes = ['image'];
    public $dirAttribute = 'id';
    public $dirName = 'files';

    public $cacheFullPath = '@app/web/frontend/cache';
    public $uploadFullPath = '@app/web/frontend/uploads';

    public $cachePath = '/cache';
    public $uploadPath = '/uploads';

    public $emptyImage = '/uploads/no-image.png';

    public $saveOldIfEmpty = true;
    public $generateUniqueName = true;

    public $deleteEvent = ActiveRecord::EVENT_BEFORE_DELETE;

    protected $_thumbWidth;
    protected $_thumbHeight;

    protected $_files = [];

    public $is_deleted;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT   => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',

            $this->deleteEvent                 => 'beforeDelete',
        ];
    }

    /**
     * Before validate event.
     */
    public function beforeValidate()
    {
        foreach ($this->attributes as $attribute) {
            if ($this->owner->{$attribute} instanceof UploadedFile) {
                continue;
            }
            $this->owner->{$attribute} = UploadedFile::getInstance($this->owner, $attribute);
        }
    }

    /**
     * Before save event.
     */
    public function beforeSave()
    {
        foreach ($this->attributes as $attribute) {
            if ($this->owner->{$attribute} instanceof UploadedFile) {
                if (!$this->owner->isNewRecord) {
                    $this->deleteOldFile($attribute);
                }
                $this->_files[$attribute]  = $this->owner->{$attribute};
                $this->owner->{$attribute} = $this->generateFileName($attribute);
            } else {
                if (!$this->owner->isNewRecord && $this->saveOldIfEmpty) {
                    if(!$this->is_deleted[$attribute]) {
                        $this->owner->{$attribute} = $this->owner->getOldAttribute($attribute);
                    } else {
                        $this->deleteOldFile($attribute);
                    }
                }
            }
        }
    }

    /**
     * After save event.
     */
    public function afterSave()
    {
        foreach ($this->_files as $attribute => $file) {
            if ($file instanceof UploadedFile) {
                $path = $this->getUploadedFilePath($this->owner->{$attribute});
                \yii\helpers\FileHelper::createDirectory(pathinfo($path, PATHINFO_DIRNAME), 0775, true);
                if (!$file->saveAs($path)) {
                    throw new Exception('File saving error.');
                }
            }
        }

    }

    /**
     * Before delete event.
     */
    public function beforeDelete($event)
    {
        foreach ($this->attributes as $attribute) {
            $path = $this->getUploadedFilePath($this->owner->{$attribute});
            @unlink($path);
        }
    }

    /**
     * Full file path
     * @param $fileName - имя файла
     * @return bool|string
     */
    public function getUploadedFilePath($fileName)
    {
        return \Yii::getAlias($this->uploadFullPath . '/' . $this->getRelativePath($fileName));
    }

    /**
     * Relative file path
     * @param $fileName
     * @return string
     */
    protected function getRelativePath($fileName)
    {
        return $this->dirName . '/' . $this->owner->{$this->dirAttribute} . '/' . $fileName;
    }

    /**
     * Full file path
     * @param $fileName - имя файла
     * @return bool|string
     */
    public function getCachedFilePath($fileName)
    {
        return \Yii::getAlias($this->cacheFullPath . '/' . $this->getCachedRelativePath($fileName));
    }

    /**
     * Relative file path
     * @param $fileName
     * @return string
     */
    protected function getCachedRelativePath($fileName)
    {
        return $this->dirName . '/' . $this->owner->{$this->dirAttribute} . '/' . $this->_thumbWidth . 'x' . $this->_thumbHeight . '/' . $fileName;
    }

    /**
     * Generate name for image (depends on generateUniqueName param)
     * @param $attribute
     * @return string
     */
    protected function generateFileName($attribute)
    {
        if ($this->generateUniqueName) {
            return \Yii::$app->security->generateRandomString(16) . '.' . $this->owner->{$attribute}->extension;
        } else {
            return $this->owner->{$attribute}->baseName . '.' . $this->owner->{$attribute}->extension;
        }
    }

    /**
     * Delete old file
     * @param $attribute
     */
    protected function deleteOldFile($attribute)
    {
        $path = $this->getUploadedFilePath($this->owner->getOldAttribute($attribute));
        @unlink($path);
    }

    /**
     * Url for full image
     * @param $attribute
     * @return bool|string
     */
    public function getFullImage($attribute)
    {
        return \Yii::getAlias($this->uploadPath . '/' . $this->getRelativePath($this->owner->{$attribute}));
    }

    /**
     * Url for thumb image with submitted width and height
     * @param $attribute
     * @return bool|string
     */
    public function getThumbImage($attribute, $width, $height)
    {
        $uploadedPath = $this->getUploadedFilePath($this->owner->{$attribute});
        if (file_exists($uploadedPath)) {
            $this->_thumbWidth  = (int)$width;
            $this->_thumbHeight = (int)$height;

            $cachePath = $this->getCachedFilePath($this->owner->{$attribute});

            if (!file_exists($cachePath)) {
                try {
                    $image = null; //new \Imagick($this->getUploadedFilePath($this->owner->{$attribute}));
                    $image->setImageCompressionQuality(100);

                    if (!$this->_thumbWidth || !$this->_thumbHeight) {
                        $image->scaleImage($this->_thumbWidth, $this->_thumbHeight);
                    } else {
                        $image->cropThumbnailImage($this->_thumbWidth, $this->_thumbHeight);
                    }


                    \yii\helpers\FileHelper::createDirectory(pathinfo($cachePath, PATHINFO_DIRNAME), 0775, true);
                    $image->writeImage($cachePath);
                } catch (\Exception $e) {
                    return $this->emptyImage;
                }
            }

            return \Yii::getAlias($this->cachePath . '/' . $this->getCachedRelativePath($this->owner->{$attribute}));
        }

        return $this->emptyImage;
    }
}
