<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_question".
 *
 * @property int $id
 * @property int $test
 * @property string $question
 * @property string $answerType
 */
class TestQuestion extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test'], 'string'],
            [['question', 'type', 'image'], 'string', 'max' => 128],
            [['file'] ,'file', 'extensions' => 'png, jpg, doc, docx, pdf, bmp, jpeg', 'skipOnEmpty' => true, 'extensions'=>'jpg, gif, png']
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
            'test' => 'Тест',
            'question' => 'Вопрос',
            'file' => 'Приложение',
        ];
    }

    public function afterSave($insert, $changedAttributes){
        if(isset($this->file)){
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            $fn = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            chmod($fn, 0444);
        }
        if($this->type == 'yes_no'){

            \Yii::$app->db->createCommand()->insert('test_answer', [
                'question' => $this->id,
                'answer' => 'Верно',
            ])->execute();

            \Yii::$app->db->createCommand()->insert('test_answer', [
                'question' => $this->id,
                'answer' => 'Неверно',
            ])->execute();
                }
                
    }
}
