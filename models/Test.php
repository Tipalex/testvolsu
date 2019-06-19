<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string $name
 * @property int $discipline
 * @property int $time
 * @property int $isPublished
 */
class Test extends \yii\db\ActiveRecord
{

    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'discipline', 'time'], 'integer'],
            [['name','type', 'filePath'], 'string', 'max' => 50, 'skipOnEmpty' => true],
            [['description'], 'string'],
            [['dateOfStart', 'dateOfEnd'], 'date', 'format' => 'php:Y-m-d'],
            ['dateOfEnd', 'compareDates', 'message'=>'Дата оканчания тестирования должна быть не раньше, чем сегодня.'],
            [['file'] ,'file', 'extensions' => 'png, jpg, doc, docx, pdf, bmp, jpeg', 'skipOnEmpty' => true],
            [['isPublished'], 'boolean'],
        ];
    }

    public function compareDates()
    {
        $now = strtotime(date('Y-m-d'));

        if (!$this->hasErrors() && ($now > strtotime($this->dateOfEnd))) {

            $this->addError('dateOfEnd', 'Дата оканчания тестирования должна быть не раньше, чем сегодня.');

        }

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
            'name' => 'Имя тестирования',
            'discipline' => 'Дисциплина',
            'time' => 'Время выполнения (в минутах)',
            'dateOfStart' => 'Дата начала тестирования',
            'dateOfEnd' => 'Дата окончания тестирования',
            'description' => 'Вступление',
            'isPublished' => 'Опубликовать'
        ];
    }

    public function afterSave($insert, $changedAttributes){
        \Yii::$app->db->createCommand("DELETE FROM student_score WHERE test_id=:test")
            ->bindValue(':test', $this->id)
            ->execute();
        return parent::afterSave($insert,$changedAttributes);
       
    }

    public function afterDelete()
    {
        \Yii::$app->db->createCommand("DELETE FROM student_score WHERE test_id=:test")
            ->bindValue(':test', $this->id)
            ->execute();
    }
    
    public static function prepareTests($student)
    {
        $tests = (new \yii\db\Query())->select('*')->from('student_score')->where(['user' => $student, ])->all();
        

        foreach ($tests as $key=> $t) {
            $tests[$key]['name'] = (new \yii\db\Query())->select('name')->from('test')->where(['id' => $t['test_id'], ])->one()['name'];
        }

        return $tests;
    }

    public static function getTests($disc = null)
    {
        return (new \yii\db\Query())->select('*')->from('test')->where(['discipline' => $disc ])->all();
    }

    public static function getUA($user, $test)
    {
        return (new \yii\db\Query())->select('*')->from('user_answers')->where(['test' => $test, 'user' => $user])->all();
    }

    public static function prepareUA($user, $test)
    {
        $test = Test::getUA($user, $test);
        foreach ($test as $key => $t) {
            $test[$key]['name'] = (new \yii\db\Query())->select('question')->from('test_question')->where(['id' => $t['question']])->one()['question'];
        }

        return $test;
    }
    public static function prepareTestData($user, $test, $discipline)
    {
        $data['test'] = Test::getUA($user, $test);
        $isAnswers = false;
        foreach ($data['test'] as $key => $t) {
            if(!empty($t['answer'])) $isAnswers = true;
        }
        if(!$isAnswers){
           \Yii::$app->db->createCommand("UPDATE student_score SET score=:score, discipline=:discipline, status='Проверено' WHERE test_id=:id and user=:user")
            ->bindValue(':id', $test)
            ->bindValue(':user', $user)
            ->bindValue(':score', 0)
            ->bindValue(':discipline', $discipline)
            ->execute(); 
        }
        foreach ($data['test'] as $key => $t) {
            $data['test'][$key]['name'] = (new \yii\db\Query())->select('question')->from('test_question')->where(['id' => $t['question']])->one()['question'];
        }
        
        $data['type'] = (new \yii\db\Query())->select('*')->from('test')->where(['id' => $test])->one()['type'];
        $data['name'] = (new \yii\db\Query())->select('*')->from('test')->where(['id' => $test])->one()['name'];

        return $data;
    }

    public static function prepareForTest($id)
    {
        $description = Test::findOne(['id' => $id])['description'];
        $name = Test::findOne(['id' => $id])['name'];
        $temp = new TestQuestion();
        $temp = $temp->findAll(['test' => $id]);
        $answers = new TestAnswer();

        $test['name'] = $name;
        $test['description'] = $description;
        $questions = array();
        foreach ($temp as $key => $value) {
            $tempAnswer = $answers->findAll(['question' => $value->id]);
            foreach ($tempAnswer as $keyA => $answer) {
                $questions[$key]['answers'][$keyA]['name'] = $answer->answer;
            }
            $questions[$key]['name'] = $value->question;
            $questions[$key]['type'] = $value->type;
            $questions[$key]['id'] = $value->id;
            $questions[$key]['key'] = $key;
            $questions[$key]['image'] = $value->image;

        }
        $result = array();
        $result['q'] = $questions; $result['test'] = $test;
        return $result;
    }

    public static function saveTest($answers, $questions, $id)
    {
            $score = 0;
            $scoreAll = 0;
            //return print_r($answers, true);
            foreach($answers as $key => $answer){
                $tempq[$key]['question'] = $questions[$key]['name'];
                $tempq[$key]['type'] = $questions[$key]['type'];
                $tempq[$key]['id'] = $questions[$key]['id'];
                if($questions[$key]['type'] == 'select_multiple'){
                    foreach($answer as $n => $a){
                        //if($questions[$key]['answers'][$n]['isRight'] == 1) $score += $questions[$key]['score'];
                        //$tempq[$key]['answer'][$n] = $a;
                        Yii::$app->db->createCommand()
                        ->insert('user_answers',[
                            'test' => $id,
                            'question' => $tempq[$key]['id'],
                            'user' => \Yii::$app->user->identity->id,
                            'answer' => $a,
                        ])->execute();
                    }
                } else{
                    Yii::$app->db->createCommand()
                    ->insert('user_answers',[
                        'test' => $id,
                        'question' => $tempq[$key]['id'],
                        'user' => \Yii::$app->user->identity->id,
                        'answer' => $answer[0],
                    ])->execute();
                    
                }
                
            
            
            }

            //$connection = Yii::$app()->db;
            Yii::$app->db->createCommand()
            ->insert('student_score',[
                'test_id' => $id,
                'score' => 0,
                'user' => \Yii::$app->user->identity->id,
                'discipline' => $id,
                'status' => 'Отправлено'
            ])->execute();

            $session = Yii::$app->session;
            $session->remove('time['.$id.']');
    }

    public static function countTime($id){
        $dateOfEnd = strtotime(date("H:i:s"));
        $duration = (new \yii\db\Query())->select(['time'])->from('test')->where(['id' => $id])->one()['time'];
        $dateOfEnd = date("H:i:s", $dateOfEnd + $duration*60);
        $session = Yii::$app->session;
        //$session->remove('time['.$id.']');
        $cureDate = date("H:i:s");
        if(!isset($session['time['.$id.']']))
        $session->set('time['.$id.']', $dateOfEnd);
        return strtotime($session->get('time['.$id.']')) - strtotime($cureDate);

    }

    public static function saveTask($id, $fileName)
    {
        $discId = (new \yii\db\Query())->select(['id'])->from('test')->where(['id' => $id])->one()['id'];
        Yii::$app->db->createCommand()
        ->insert('user_answers',[
        'test' => $id,
        'question' => 0,
        'user' => \Yii::$app->user->identity->id,
        'answer' => $fileName,
        ])->execute();
        Yii::$app->db->createCommand()
        ->insert('student_score',[
            'test_id' => $id,
            'score' => 0,
            'user' => \Yii::$app->user->identity->id,
            'discipline' => $discId,
            'status' => 'Отправлено'
        ])->execute();
    }
}
