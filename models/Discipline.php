<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discipline".
 *
 * @property int $id
 * @property int $teacher
 * @property int $name
 * @property double $control
 */
class Discipline extends \yii\db\ActiveRecord
{
    public $teacher_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher'], 'integer'],
            [['name', 'control', 'teacher_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher' => 'Преподаватель дисциплины',
            'name' => 'Название дисциплины',
            'control' => 'Вид контроля',
            'teacher_name' => 'Преподаватель дисциплины'
        ];
    }


    public static function getDisciplines($teacher=null)
    {
        $result = (new \yii\db\Query())
        ->select(['id', 'name'])
        ->from('discipline');
        if(!empty($teacher)) $result->where(['teacher' => $teacher]);
        return $result->all();
    }

    public static function prepareModel($gd)
    {
        $model = array();
        $temp = (new \yii\db\Query())
        ->select(['name', 'id'])
        ->from('discipline');

        foreach ($gd as $key => $d) {
            $d->discipline_name = Discipline::findOne(['id' => $d->discipline])->name;

            $temp->andWhere(['<>', 'id', $d->discipline]);
        }

        foreach ($temp->all() as $d_id => $d) {
            $model[$d['id']] = $d['name'];
        }

        return $model;
    }

    public static function customSave($teacher, $discipline)
    {
        \Yii::$app->db->createCommand()->insert('discipline', [
            'teacher' => $teacher,
            'name' => $discipline,
            'control' => 'зачёт'
        ])->execute();
    }

    public static function prepareDisciplines($group){
        $temp = (new \yii\db\Query())->select(['id', 'discipline'])->from('group_discipline')->where(['groupe' => $group])->all();

        foreach ($temp as $key => $d) {
            $discipline[$key]['id'] = $d['discipline'];

            $disc = (new \yii\db\Query())->select(['teacher', 'name', 'control'])->from('discipline')->where(['id' => $d['discipline']])->one();
            $discipline[$key]['name'] = $disc['name'];
            $discipline[$key]['control'] = $disc['control'];

            $teacher = (new \yii\db\Query())->select(['firstname', 'lastname', 'middlename'])->from('user')->where(['id' => $disc['teacher']])->one();
            $discipline[$key]['teacher'] = $teacher['firstname'] . " " . $teacher['middlename']." ".$teacher['lastname'];

            $score = (new \yii\db\Query())->select(['score'])->from('student_score')->where(['user' => \Yii::$app->user->identity->id, 'discipline' => $d['discipline']])->all();
            $discipline[$key]['score'] = 0;
            foreach ($score as $s) {
                $discipline[$key]['score'] += $s['score'];
            }

        }

        return $discipline;
    }

    public static function prepareForStudent($id)
    {
                $disc = (new \yii\db\Query())->select(['teacher', 'name', 'control'])->from('discipline')->where(['id' => $id])->one();
        $discipline['name'] = $disc['name'];
        $discipline['control'] = $disc['control'];

        $teacher = (new \yii\db\Query())->select(['firstname', 'lastname', 'middlename'])->from('user')->where(['id' => $disc['teacher']])->one();
        $discipline['teacher'] = $teacher['firstname'] . " " . $teacher['middlename']." ".$teacher['lastname'];


        //$tests = (new \yii\db\Query())->select('*')->from('test')->where(['discipline' => $id, ])->andWhere('dateOfEnd + interval 1 day > NOW()')->andWhere(['<=', 'dateOfStart', new Expression('NOW()')])->all();
        $tests = (new \yii\db\Query())->select('*')->from('test')->where(['discipline' => $id, 'isPublished' => 1])->all();

        foreach ($tests as $key => $test) {
            $discipline['test'][$test['id']] = $test;
            $test_score = (new \yii\db\Query())->select('*')->from('student_score')->where(['test_id' => $test['id'], 'user' => \Yii::$app->user->identity->id])->one();
            //if($key == 4) return print_r($test_score['status'], true);
            if(strtotime($test['dateOfEnd']) < strtotime(date('Y-m-d')) && ($test_score['status'] == "Не выполнено" || empty($test_score['status'])) ){
                if(!empty($test_score['status']))
                    Yii::$app->db->createCommand('UPDATE INTO student_score (status) VALUES (:status) where test_id = :test_id and user = :user', [
                        ':status' => 'Не выполнено в срок',
                        ':test_id' => $test['id'],
                        ':user' => \Yii::$app->user->identity->id,
                    ])->execute();
                else 
                    Yii::$app->db->createCommand()
                    ->insert('student_score',[
                    'test_id' => $test['id'],
                    'status' => 'Не выполнено в срок',
                    'user' => \Yii::$app->user->identity->id,
                    'score' => 0,
                    'discipline' => $id,
                    ])->execute();
                $test_score['status'] = 'Не выполнено в срок';
                $test_score['score'] = 0;
            }
            if(empty($test_score)){
                 $discipline['test'][$test['id']]['status'] = "Не выполнено";
                 $discipline['test'][$test['id']]['score'] = "0";
            } else{
                $discipline['test'][$test['id']]['status'] = $test_score['status'];
                 $discipline['test'][$test['id']]['score'] = $test_score['score'];
            }
        }

        return $discipline;
    }

}
