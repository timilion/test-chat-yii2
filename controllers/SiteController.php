<?php

namespace app\controllers;

use app\models\ChatMessage;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'new-message', 'login', 'incorrect'],
                'rules' => [
                    [
                        'actions' => ['incorrect'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['logout', 'new-message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'new-message' => ['post']
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
        $model = ChatMessage::find()->all();
        return $this->render('index', compact('model'));
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionIncorrect($id)
    {
        $model = ChatMessage::findOne($id);
        if($model && $model->status === ChatMessage::STATUS_CORRECTLY) {
            $model->status = ChatMessage::STATUS_INCORRECT;
            $model->save();
        }
        return $this->redirect(['site/index']);
    }

    /**
     * @return Response
     */
    public function actionNewMessage()
    {
        $message = Yii::$app->request->post('message');
        if (trim($message)) {
            $model = new ChatMessage();
            $model->user_id = Yii::$app->user->identity->id;
            $model->text = $message;
            $model->save();
        }
        return $this->redirect(['site/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['login'])) {
                $model->scenario = LoginForm::SCENARIO_LOGIN;
                if ($model->login()) {
                    return $this->redirect(['/']);
                }
            }

            if (isset($_POST['registr'])) {
                $model->scenario = LoginForm::SCENARIO_REGISTER;
                if ($model->register()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => 'Регистрация завершена. Войдите',
                        'options' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect(['site/login']);
                }
            }
        }

        return $this->render('login', compact('model'));
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
}
