<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use DateTime;
use yii\helpers\VarDumper;

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
                        'roles' => ['@'],
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {  

        $model = new LoginForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if(isset($_POST['add'])) {
                VarDumper::dump($_POST);
                $datetime = new DateTime();
                $model->username = $data['username'];
                $model->password = $data['password'];
                $model->created_at = $datetime;
                if($model->save()) {
                    echo json_encode(array('status' => 'success', 'message' => 'User has been created'));
                }
                else {
                    echo json_encode(array('status' => 'failure', 'message' => 'User has not been created'));
                }
            } else if (isset($_POST['check'])) {
                $model->username = $this->username;
                $model->password = $this->password;
                if($model->findUser($model->username, $model->password)){
                return json_encode(array('status' => 'success', 'message' => 'User exists'));
            }
            else {
                return json_encode(array('status' => 'failure', 'message' => 'User does not exist'));
            }
        }
    }
    
        
return $this->render('login', [
    'model' => $model,
]);
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
