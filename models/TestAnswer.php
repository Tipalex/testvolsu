<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_answer".
 *
 * @property int $id
 * @property int $question
 * @property string $answer
 * @property string $isRight
 */
class TestAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'string'],
            [['answer'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
        ];
    }

    public static function countAnswers($user, $test)
    {
        return (new \yii\db\Query())->select('*')->from('user_answers')->where(['test' => $test, 'user' => $user])->count();
    }

    public static function getAnswers($user, $test)
    {
       return (new \yii\db\Query())->select(['id', 'score'])->from('user_answers')->where(['test' => $test, 'user' => $user])->all();
    }

    public static function updateStudentTest($answers, $id, $user, $discipline)
    {
        $score = 0;
        foreach ($answers as $key => $value) {
                if(is_numeric($value['score'])){
                    //$value->setScore(Yii::$app->request->post()['ScoreForm'][0]['score']);
                    \Yii::$app->db->createCommand("UPDATE user_answers SET score=:score WHERE id=:id")
                    ->bindValue(':id', $model[$key]->id)
                    ->bindValue(':score', $value['score'])
                    ->execute();
                    //return print_r($value, true);
                    //$value->save();
                    if(is_numeric($value['score']))
                    $score += $value['score'];
                }
            }
            \Yii::$app->db->createCommand("UPDATE student_score SET score=:score, discipline=:discipline, status='Проверено' WHERE test_id=:id and user=:user")
            ->bindValue(':id', $id)
            ->bindValue(':user', $user)
            ->bindValue(':score', $score)
            ->bindValue(':discipline', $discipline)
            ->execute();
    }
}
