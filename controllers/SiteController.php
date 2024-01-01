<?php

namespace app\controllers;

use app\models\Book;
use app\models\LoginForm;
use app\models\Weather;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    private const PAGE_LIMIT = 8;

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

    public function actionIndex(): string
    {
        $cities = Yii::$app->request->get('cities', ['Brasilia', 'Tokyo', 'Munich', 'Pretoria', 'Auckland']);

        if (!is_array($cities)) {
            $cities = explode(',', $cities);
            $cities = array_map(function ($city) {
                return trim($city);
            }, $cities);
        }
        return $this->render('home', [
            'weather' => Weather::getWeather($cities),
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionBooks(): string
    {
        return $this->render('books', [
            'books' => Book::find()->all() ?? [],
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
        $limit  = Yii::$app->request->get('limit', self::PAGE_LIMIT);
        $offset = (Yii::$app->request->get('page', 1) - 1) * $limit;
        $books  = Book::find()
            ->orWhere(['like', 'title', '%' . Yii::$app->request->get('search') . '%', false])
            ->orWhere(['like', 'description', '%' . Yii::$app->request->get('search') . '%', false])
            ->orWhere(['like', 'author', '%' . Yii::$app->request->get('search') . '%', false])
            ->offset($offset)
            ->limit($limit);

        if (Yii::$app->request->get('id')) {
            $books->where(['id' => Yii::$app->request->get('id')]);
        }
        return Json::encode([
            'metadata' => [
                'total' => $books->count(),
                'limit' => Yii::$app->request->get('limit', self::PAGE_LIMIT),
            ],
            'data'     => $books->all(),
        ]);
    }

    public function actionPost(): string
    {
        $response = ['error' => ''];
        try {
            $book               = new Book();
            $book->title        = Yii::$app->request->post('title');
            $book->author       = Yii::$app->request->post('author');
            $book->description  = Yii::$app->request->post('description');
            $book->pages_number = Yii::$app->request->post('pages_number');
            $book->save();
        } catch (Exception $e) {
            $response['error'] = 'Error saving the book';
        }
        return Json::encode($response);
    }

    public function actionPut($bookId): string
    {
        $response = ['error' => ''];
        try {
            $book               = Book::findOne($bookId);
            $book->title        = Yii::$app->request->post('title');
            $book->author       = Yii::$app->request->post('author');
            $book->description  = Yii::$app->request->post('description');
            $book->pages_number = Yii::$app->request->post('pages_number');
            $book->save();
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
        return Json::encode($response);
    }

    public function actionDelete($bookId): string
    {
        $response = ['error' => ''];
        try {
            $book = Book::findOne($bookId);
            if ($book) {
                $book->delete();
            } else {
                $response['error'] = 'The book you tried to delete was already deleted or not found.';
            }
        } catch (Exception $e) {
            $response['error'] = 'Error deleting the book';
        }
        return Json::encode($response);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->redirect(['/login']);
    }

}
