<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "credit".
 *
 * @property int $id
 * @property int $user
 * @property int $type
 * @property double $debt
 * @property double $amount
 */
class Credit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'type'], 'integer'],
            [['debt', 'amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'type' => 'Type',
            'debt' => 'Debt',
            'amount' => 'Amount',
        ];
    }
}
