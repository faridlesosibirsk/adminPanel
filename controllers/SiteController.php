<?php

namespace app\controllers;

use app\models\Post;
use app\models\Mod;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use yii\web\ForbiddenHttpException;

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
    {/*
        if (!\Yii::$app->user->can('updateNews')) {
            throw new ForbiddenHttpException('Access denied');
        }*/
        //return $this->render('index');
        $this->layout = 'default';
        return $this->render('default');
    }

    /**
     * Post action.
     *
     * @return string
     */
    public function actionPost($id)
    {
        $model = new Post($id);
        return $this->render('post', ['model' => $model]);
    }

    /**
     * Mod action.
     *
     * @return string
     */
    public function actionMod($id)
    {
        $model = new Mod($id);
        return $this->render('mod', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }


        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Форма регистрации.
     *
     * @return mixed
     */
    public function actionSignup()
    {///////////////////////////////////////////////////////////
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }        
        if (\Yii::$app->user->can('updateNews3')) {
            $this->layout = 'default';
            return $this->render('signup', [
                'model' => $model,
            ]);
        } {
            return $this->goHome();
        }
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
/*public function actionError()
{
    $exception = Yii::$app->errorHandler->exception;
    if ($exception !== null) {
        return $this->render('error', ['exception' => $exception]);
    }
}
public function actionError()
{
    $exception = Yii::$app->errorHandler->exception;
    if ($exception instanceof \yii\web\NotFoundHttpException) {
        // all non existing controllers+actions will end up here
        return $this->render('pnf'); // page not found
    } else {
      return $this->render('error', ['exception' => $exception]);
    }
}*/
}
