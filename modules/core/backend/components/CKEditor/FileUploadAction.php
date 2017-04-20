<?php

namespace app\modules\core\backend\components\CKEditor;

use Yii;
use yii\web\UploadedFile;

class FileUploadAction extends \yii\base\Action
{
    /**
     * Name of the param to handle
     * @var string
     */
    public $uploadName = 'upload';

    /**
     * Name of the param to handle
     * @var string
     */
    public $uploadPath = '@uploads/';

    /**
     * Relative path to web-accessible folder
     * @var string
     */
    public $relativePath = '/uploads/';

    /**
     * Private variable for getter
     * @var \yii\web\UploadedFile
     */
    private $_file;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $response = '';

        if (null !== $this->file) {

            $fileName = $this->file->baseName . '.' . $this->file->extension;
            $filePath = Yii::getAlias($this->uploadPath . $fileName);

            if ($this->file->saveAs($filePath)) {

                $funcNum  = Yii::$app->getRequest()->get('CKEditorFuncNum');
                $imageUrl = Yii::getAlias($this->relativePath . $fileName);

                $response =
                    'window.parent.CKEDITOR.tools.callFunction(' .
                    $funcNum . ', "' . $imageUrl . '", ' . '"Изображение загружено!"' .
                    ');';
            }
        } else {
            $response = 'alert("Что-то пошло не так.")';
        }

        return '<script>'.$response.'</script>';
    }

    /**
     * Function to handle UploadedFile
     * @return \yii\web\UploadedFile|null Instance of UploadedFile class or null if is not handled
     */
    public function getFile()
    {
        return isset($this->_file) ? $this->_file :
            $this->_file = UploadedFile::getInstanceByName($this->uploadName);
    }
}
