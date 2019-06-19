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
class Group extends \yii\db\ActiveRecord
{
    public $teacher_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название группы',
        ];
    }

    public static function getGroups($disc)
    {
        return (new \yii\db\Query())
        ->select(['student_group.id', 'student_group.name'])
        ->from('student_group, group_discipline')
        ->where(['group_discipline.discipline' => $disc])->distinct()->all();
    }

    public static function getAllGroups()
    {
        $temp = (new \yii\db\Query())
        ->select(['*'])
        ->from('student_group')
        ->all();

        foreach ($temp as $k => $t) {
            $groups[$t['id']] = $t['name'];
        }

        return $groups;
    }    

    public static function gG(){
        return (new \yii\db\Query())
        ->select(['*'])
        ->from('student_group')
        ->all();
    }
}
