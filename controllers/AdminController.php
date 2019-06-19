<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\BackendUser;
use app\models\Discipline;
use app\models\Group;
use app\models\Group_discipline;
use yii\db\Query;

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }




    public function actionIndex()
    {
        $users = BackendUser::getUsers();

        return $this->render('index', ['users' => $users]);
    }

    public function actionDeleteuser($id)
    {
        $user = BackendUser::findOne($id);
        $user->delete();

        return $this->redirect(['admin/index']);
    }

    public function actionCreateuser($id = null)
    {   
        $groups = Group::getAllGroups();

        $old = false;

        $model = new BackendUser();
        if(!empty($id)){
            $model = BackendUser::findOne($id);
            $old = true;
        }
        
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->save();
                return $this->redirect(['admin/index']);
            }
        }

        return $this->render('createUser', [
            'model' => $model,
            'old' => $old,
            'groups' => $groups
        ]);
    }

    public function actionViewuser($id){
        $disciplines = Discipline::findAll(['teacher' => $id]);
        $fio = BackendUser::findOne($id)->getFIO();
        //$fio = $fio->FIO();
        return $this->render('viewUser', [
            'disciplines' => $disciplines,
            'FIO' => $fio,
        ]);
    }

    public function actionDeletediscipline($id, $teacher)
    {
        $user = Discipline::findOne($id);
        $user->delete();

        return $this->redirect(['admin/viewuser', 'id' => $teacher]);
    }


    public function actionCreatediscipline($id = null, $teacher)
    {   
        $model = new Discipline();
        if(!empty($id))
        $model = Discipline::findOne($id);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->teacher = $teacher;
            if ($model->validate()) {

                $model->save();
                return $this->redirect(['admin/viewuser', 'id' => $teacher]);
            }
        }
        $fio = BackendUser::findOne($teacher)->getFIO();
        return $this->render('createDiscipline', [
            'model' => $model,
            'FIO' => $fio
        ]);
    }

    public function actionViewgroups(){
        $groups = Group::gG();

        return $this->render('viewGroups', ['groups' => $groups]);
    }

    public function actionDeletegroup($id)
    {
        $group = Group::findOne(['id' => $id]);
        $group->delete();

        return $this->redirect(['admin/viewgroups']);
    }

    public function actionCreategroup($id = null){
       $model = new Group();
        if(!empty($id))
        $model = Group::findOne($id);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->save();
                return $this->redirect(['admin/viewgroups']);
            }
        }
        return $this->render('createGroup', [
            'model' => $model
        ]); 
    }

    public function actionDeletegd($id, $group){
        $group_model = Group_discipline::findOne($id);
        $group_model->delete();

        return $this->redirect(['admin/groupdisciplines', 'id' => $group]);
    }

    public function actionGroupdisciplines($id){
        $gd = Group_discipline::findAll(['groupe' => $id]);
        $modelGD = new \yii\base\DynamicModel(['discipline']);
        $modelGD->addRule(['discipline'], 'integer', ['max' => 128]);

        if ($modelGD->load(Yii::$app->request->post()) && $modelGD->validate()) {
            Group_discipline::customSave($id, $modelGD->discipline);

            return $this->refresh();
            
        }
        $modelGD = new \yii\base\DynamicModel(['discipline']);

        $model = Discipline::prepareModel($gd);
            
        return $this->render('groupDisciplines', [
            'gd' => $gd,
            'model' => $model,
            'modelGD' => $modelGD
        ]); 
    }

    public function actionUd($id){

        $gd = Discipline::findAll(['teacher' => $id]);
        $model = array();
        $modelGD = new \yii\base\DynamicModel(['discipline']);
        $modelGD->addRule(['discipline'], 'string', ['max' => 128]);
        if ($modelGD->load(Yii::$app->request->post()) && $modelGD->validate()) {
            Discipline::customSave($id, $modelGD->discipline);
            return $this->refresh();
            
        }
        $modelGD = new \yii\base\DynamicModel(['discipline']);

        $model = Discipline::prepareModel($gd);
            
        return $this->render('teacherDisciplines', [
            'gd' => $gd,
            'model' => $model,
            'modelGD' => $modelGD
        ]); 
    }

    public function actionDeleteud($id, $teacher){
        $group_model = Discipline::findOne($id);
        $group_model->delete();

        return $this->redirect(['admin/ud', 'id' => $teacher]);
    }
}