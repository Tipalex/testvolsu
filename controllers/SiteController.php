<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\BackendUser;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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



    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'teacher') $this->redirect('?r=teacher/index', 302);
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'student') $this->redirect('?r=student/index', 302);
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'admin') $this->redirect('?r=admin/index', 302);
            
        //else return print_r(\Yii::$app->user->identity, true);
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //\Yii::$app->user->setRole();
            if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'teacher') $this->redirect('?r=teacher/index', 302);
            if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'student') $this->redirect('?r=student/index', 302);
            if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'admin') $this->redirect('?r=admin/index', 302);
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'teacher') $this->redirect('?r=teacher/index', 302);
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'student') $this->redirect('?r=student/index', 302);
        if(!empty(\Yii::$app->user->identity) && \Yii::$app->user->identity->role == 'admin') $this->redirect('?r=admin/index', 302);
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        //$model->load(Yii::$app->request->post());
        //print_r($model->login()); exit();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $u = new BackendUser();
            \Yii::$app->user->setRole();
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


}
