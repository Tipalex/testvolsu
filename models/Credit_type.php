<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "credit_type".
 *
 * @property int $id
 * @property string $name
 * @property double $percent
 */
class Credit_type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credit_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percent'], 'number'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'percent' => 'Percent',
        ];
    }
}
