<?php

/*
 * Класс для действий незерегистрированного пользователя
 *
 */

namespace app\controllers;

use app\models\User;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserForm;
use app\models\Form\UserPassword as FormUserPassword;
use Suffra\Config as SuffraConfig;


class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'profile', 'profile_password_change'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile', 'profile_password_change'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];

    }

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
            'usersBlock' => 'app\controllers\Users\Block'
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * Выводит страницу логина по запросу GET
     * и логинит пользователя если был запрос POST
     *
     *
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            self::log('Вошел в систему');
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        self::log('Вышел из системы');
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Выводит профиль пользователя
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'user' => User::findIdentity(
                Yii::$app->user->getId()
            ),
        ]);
    }

    /**
     * Выводит форму редактирования для новостной ленты и обновляет через POST
     */
    public function actionProfile_password_change()
    {
        $model = FormUserPassword::find(
            Yii::$app->user->getId()
        );
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            self::log('Поменял пароль себе');
            return $this->refresh();
        } else {
            return $this->render('profile_password_change', [
                'model' => $model,
            ]);
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Логирует действие пользователя
     */
    public function log($description) {
        parent::logAction(Yii::$app->user->identity->id, $description);
    }
}