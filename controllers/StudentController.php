<?php

namespace app\controllers;
use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\db\Command;
use app\models\Test;
use app\models\TestAnswer;
use app\models\TestQuestion;
use app\models\FileForm;
use app\models\Materials;
use app\models\BackendUser;
use app\models\Discipline;
use yii\web\UploadedFile;

class StudentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $group = BackendUser::getGroup(\Yii::$app->user->identity->id);

        $discipline = Discipline::prepareDisciplines($group);

        return $this->render('index', ['disciplines' => $discipline]);
    }

    public function actionPasstest($id = null, $passed = false){

        $temp = Test::prepareForTest($id);

        $questions = $temp['q'];
        $test = $temp['test'];
        

        if(!$passed)
    	shuffle($questions);
    	foreach ($questions as $key => $value) {
            if($questions[$key]['type'] == 'select' && !$passed)
    		shuffle($questions[$key]['answers']);
    	}
        
    	if($passed){
            if(isset($_POST['qu']))
    		  $answers = $_POST['qu'];
            else $answers = [];

            Test::saveTest($answers, $questions, $id);
    		return $this->redirect('?r=student/index');
    	}

        
        $timeLeft = Test::countTime($id);

        $needToSubmit = false;
        if($timeLeft < 0 || $timeLeft > 4*60*60) $needToSubmit = true;

    	return $this->render('passtest', ['model' => $questions, 'test' => $test,  'dateLeft' => date("H:i:s", $timeLeft), 'needToSubmit' => $needToSubmit]);
    }


    public function actionDiscipline($id){
        $discipline = Discipline::prepareForStudent($id);

        $materials = Materials::find()->where(['discipline' => $id])->all();
        //return print_r(date('Y-m-d'), true);
        return $this->render('discipline', ['discipline' => $discipline, 'materials' => $materials]);
    }

    public function actionChecktest($id){
        $test = Test::prepareUA($id, \Yii::$app->user->identity->id);
        $test_model = Test::findOne(['id' => $id]);
        $type = $test_model['type'];

        $name = $test_model['name'];
        $description = $test_model['description'];

        return $this->render('checkTest', [
            'test' => $test,
            'type' => $type,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function actionPasstask($id){
        $model = new FileForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate() && $model->upload()) {
                $fileName = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                Test::saveTask($id, $fileName);
                return $this->redirect('?r=student/index');
            }
        }
        $description = Test::findOne(['id' => $id])['description'];
        $name = Test::findOne(['id' => $id])['name'];

        $test['name'] = $name;
        $test['description'] = $description;
        $file = Test::findOne(['id' => $id])['filePath'];
        return $this->render('passTask', [
            'model' => $model,
            'test' => $test,
            'file' => $file
        ]);
    }

    public function actionGetfile($name){
        $root=Yii::getAlias('@webroot')."/".$name;
        if (file_exists($root)) {
            return Yii::$app->response->sendFile($root);
        } else {
            throw new \yii\web\NotFoundHttpException("{$name} is not found!");
        }
    }
}
