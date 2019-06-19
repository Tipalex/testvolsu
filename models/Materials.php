<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string $name
 * @property int $discipline
 * @property int $filePath
 * @property int $name
 */
class Materials extends \yii\db\ActiveRecord
{

    public $file;
    public $disc_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'discipline'], 'integer'],
            [['name','filePath', 'disc_name'], 'string','skipOnEmpty' => true, 'max' => 500],
            [['file'] ,'file', 'extensions' => 'png, jpg, doc, docx, pdf, bmp, jpeg', 'skipOnEmpty' => true]
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


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя файла',
            'discipline' => 'Дисциплина',
            'disc_name' => 'Дисциплина',
        ];
    }
}
