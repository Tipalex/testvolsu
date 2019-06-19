<?php

namespace app\controllers;
use Yii;
use yii\db\Query;
use yii\base\Model;
use app\models\Test;
use app\models\TestAnswer;
use app\models\TestQuestion;
use app\models\ScoreForm;
use app\models\Materials;
use app\models\Discipline;
use app\models\Group;
use app\models\BackendUser;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;


class TeacherController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$user_id = \Yii::$app->user->identity->id;
    	
        $disciplines = Discipline::getDisciplines($user_id);
        return $this->render('index',
    	['disc' => $disciplines]);
    }

    public function actionDiscipline($id, $group=null, $student=null)
    {
    	$groups = Group::getGroups($id);

    	if(isset($group)){ 
    		$students = BackendUser::getStudents($group);
    	} else $students = null;

        if(isset($student)){ 
            $tests = Test::prepareTests($student);
        } else $tests = null;

        $materials = Materials::find()->where(['discipline' => $id])->all();

    	return $this->render('discipline',
    		['groups' =>$groups,
    		'students' => $students,
            'tests' => $tests,
            'materials' => $materials]
    	);
    }

    public function actionTests(){
        $query = Test::find()->where(['type' => 'test']);

        $provider = new ActiveDataProvider([
            'query' => $query,

        ]);

        return $this->render('tests',
            ['provider' => $provider]
        );
    }

    public function actionCreatetest(){
        $model = new Test();
        $discipline = Discipline::getDisciplines(\Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['teacher/viewquestions', 'test' => $model->id]);
            }
        }

        return $this->render('createTest', [
            'model' => $model,
            'discipline' => $discipline
        ]);

    }

    public function actionEdittest($id){
        $model = new Test();
        $discipline =  Discipline::getDisciplines();

        $model = $model->findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect('?r=teacher/tests');
            }
        }

        return $this->render('editTest', [
            'model' => $model,
            'discipline' => $discipline
        ]);
    }

    public function actionViewquestions($test){
        $query = TestQuestion::find()->where(['test' => $test]);

        $provider = new ActiveDataProvider([
            'query' => $query,

        ]);

        return $this->render('viewquestions',
            ['provider' => $provider]
        );
    }

    public function actionCreatequestion($test, $question = null){
        $model = new TestQuestion();

        $test_name = Test::findOne($test)->name;

        if(isset($question)) $model = $model->findOne($question);

        if ($model->load(Yii::$app->request->post())) {
            $model->test = $test;
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {

                if(isset($model->file))
                    $model->image = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                else $model->image = null;

            
                $model->save();
                
                if($model->type != 'write')
                    return $this->redirect(['teacher/viewanswers', 'quest' => $model->id, 'test' => $test]);
                else
                    return $this->redirect(['teacher/viewquestions', 'test' => $test]);
            }
        }

        return $this->render('testquestion', [
            'model' => $model,
            'name' => $test_name
        ]);
    }

    public function actionViewanswers($quest){

        $query = TestAnswer::find()->where(['question' => $quest]);

        $provider = new ActiveDataProvider([
            'query' => $query,

        ]);

        return $this->render('viewanswers',
            ['provider' => $provider]
        );
    }

    public function actionCreateanswer($quest, $test, $answer = null){
        $model = new TestAnswer();
        $question = TestQuestion::findOne($quest)->question;
        if(isset($answer))
        $model = $model->findOne($answer);

        if ($model->load(Yii::$app->request->post())) {
            $model->question = $quest;
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['teacher/viewanswers', 'quest' => $quest, 'test' => $test]);
            }
        }

        return $this->render('createanswer', [
            'model' => $model,
            'question' => $question
        ]);
    }


    public function actionChecktest($id, $user, $discipline){
        $model = [new ScoreForm()];

        $amount = TestAnswer::countAnswers($user, $id);
        $id_answers = TestAnswer::getAnswers($user, $id);
        $answer_scores = array();
        for($i = 0; $i < $amount; $i++){    
             $model[$i] = ScoreForm::findOne($id_answers[$i]['id']);
             $answer_scores[$i] = $id_answers[$i]['score'];
         }

        if (Model::loadMultiple($model, Yii::$app->request->post()) && Model::validateMultiple($model)) 
        {
            TestAnswer::updateStudentTest(Yii::$app->request->post()['ScoreForm'], $id, $user, $score, $discipline);
            return $this->redirect(['teacher/discipline', 'id' => $discipline]);
        }

        $data = Test::prepareTestData($user, $id, $discipline);
        
        return $this->render('checkTest', [
            'test' => $data['test'],
            'model' => $model,
            'answer_scores' => $answer_scores,
            'type' => $data['type'],
            'name' => $data['name']
        ]);
    }

    public function actionDeletetest($id){
        $model = Test::findOne(['id' => $id]);
        $model->delete();


        return $this->redirect(['teacher/tests']);
    }

    public function actionDeletequestion($id){
        $model = TestQuestion::findOne(['id' => $id]);
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteanswer($id){
        $model = TestAnswer::findOne(['id' => $id]);
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTasks(){
        $query = Test::find()->where(['type' => 'tack']);

        $provider = new ActiveDataProvider([
            'query' => $query,

        ]);

        return $this->render('tasks',
            ['provider' => $provider]
        );
    }

    public function actionCreatetask(){
        $model = new Test();
        $discipline =  Discipline::getDisciplines();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {

                if(isset($model->file)){
                    $model->filePath = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                }
                else $model->filePath = 'null';

                $model->type = 'tack';

                $model->save();

                $model->upload();
                return $this->redirect(['teacher/tasks']);
            }
        }

        return $this->render('createTask', [
            'model' => $model,
            'discipline' => $discipline
        ]);
    }

    public function actionEditetask($id){
        $model = new Test();
        $discipline =  Discipline::getDisciplines();
        $model = $model->findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {

                if(isset($model->file) && $model->upload())
                $model->filePath = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                else $model->filePath = NULL;
                $model->type = 'tack';

                $model->save();
                return $this->redirect(['teacher/tasks']);
            }
        }

        return $this->render('editeTask', [
            'model' => $model,
            'discipline' => $discipline
        ]);
    }

    public function actionDeletetask($id){
        $model = Test::findOne(['id' => $id]);
        $model->delete();

        return $this->redirect(['teacher/tasks']);
    }

    public function actionGetfile($name){
        $storagePath = '../web';
        $root = $storagePath.'/'.$name;
        if (file_exists($root)) {
            return Yii::$app->response->sendFile($root);
        } else {
            throw new \yii\web\NotFoundHttpException("{$root} is not found!");
        }
    }

    public function actionCreatematerial($discipline, $id = null){
        $model = new Materials();
        if(!empty($id)) $model = $model->findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->discipline = $discipline;
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate() && (!empty($id) || !empty($model->file))) {

                if(isset($model->file) && $model->upload())
                $model->filePath = 'uploads/' . $model->file->baseName . '.' . $model->file->extension;
                else if(empty($id)) $model->filePath = NULL;

                $model->save();
                return $this->redirect(['teacher/discipline', 'id' => $discipline]);
            }
        }
        $discipline_name = Discipline::findOne(['id' => $discipline])['name'];
        return $this->render('createMaterial', [
            'model' => $model,
            'discipline' => $discipline_name
        ]);
    }

    public function actionDeletematerial($id, $discipline){
        $model = Materials::findOne(['id' => $id]);
        $model->delete();

        return $this->redirect(['teacher/discipline', 'id' => $discipline]);
    }
}
