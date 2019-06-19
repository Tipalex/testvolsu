<?php
namespace app\models;

use Yii;

class ScoreForm extends \yii\db\ActiveRecord
{
    public $score;

    public static function tableName()
    {
        return 'user_answers';
    }

    public function rules()
    {
        return [
        	[['score'], 'integer'],
            // define validation rules here
        ];
    }

    public function setScore($score){
    	$this->score = $score;
    }
}