<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Groupe_discipline".
 *
 * @property int $id
 * @property int $teacher
 * @property int $name
 * @property double $control
 */
class Group_discipline extends \yii\db\ActiveRecord
{
    public $discipline_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['groupe', 'discipline'], 'integer'],
            [['discipline_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupe' => 'Группы',
            'discipline_name' => 'Название дисциплины',
        ];
    }

    public static function customSave($group, $discipline)
    {
        \Yii::$app->db->createCommand()->insert('group_discipline', [
            'groupe' => $group,
            'discipline' => $discipline,
        ])->execute();
    }
}
