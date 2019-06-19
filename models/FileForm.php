<?php
namespace app\models;

use Yii;
use yii\base\Model;

class FileForm extends \yii\base\Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'] ,'file', 'extensions' => 'png, jpg, doc, docx, pdf, bmp, jpeg', 'skipOnEmpty' => false]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            $fn = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            chmod($fn, 0444);
            return true;
        } else {
            return false;
        }
    }
}