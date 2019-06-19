<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\Query;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $email
 * @property string $authKey
 */
class BackendUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $group;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'firstname', 'lastname', 'middlename', 'email', 'authKey', 'role'], 'string', 'max' => 128],
            [['group'], 'string', 'skipOnEmpty' => true]
        ];
    }

    public function getAuthKey(){
        return $this->authKey;
    }

    public function setRole(){
        $query = new Query;
        \Yii::$app->user->identity->role =  $this->role;
    }

    public function getId(){
        return $this->id;
    }

    public function getRole(){
        return $this->role;
    }

    public function getFIO(){
        return $this->lastname." ".$this->firstname." ".$this->middlename;
    }

    public function validateAuthKey($authKey){
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public function findByUserName($username){
        return self::findOne(['login' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        return true;
    }

    public function validatePassword($password){
        return $this->password === $password;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'email' => 'Email',
            'authKey' => 'Auth Key',
        ];
    }

    public function afterSave($insert, $changedAttributes){

        if($this->role == 'student'){
            \Yii::$app->db->createCommand()->insert('student', [
                'user' => $this->id,
                's_group' => $this->group,
            ])->execute();
        }
    }

    public static function getStudents($group)
    {
        return (new \yii\db\Query())
            ->select(['user.id', 'user.firstname', 'user.lastname', 'user.middlename'])
            ->from(['user', 'student'])
            ->where(['student.s_group' => $group])->andWhere('student.user = user.id')->distinct()->all();
    }

    public static function getUsers()
    {
        return (new \yii\db\Query())
        ->select(['*'])
        ->from('user')
        ->all();
    }

    public static function getGroup($user){
        return (new \yii\db\Query())->select('s_group')->from('student')->where(['user' => $user])->one()['s_group'];
    }

    
}
