<?php

namespace app\controllers;

use app\models\Books;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class BooksController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action): Response|bool|\yii\console\Response
    {
        if (Yii::$app->user->isGuest && Url::current() != '/login') {
            return Yii::$app->getResponse()->redirect(['/login']);
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('books', [
            'books' => Books::find()->all(),
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
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

    public function actionGet(): bool|string
    {
        dump(Yii::$app->request->get('id'));
        return Json::encode(
            Books::find()->where(['id' => Yii::$app->request->get('id')])->all()
        );
    }

    public function actionLogout(): Response
    {
        // Perform logout actions
        Yii::$app->user->logout();

        // Redirect to the desired page after logout
        return $this->redirect(['/login']);
    }

}
