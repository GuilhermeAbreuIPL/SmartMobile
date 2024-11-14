<?php

namespace backend\controllers;

use common\models\LoginForm;
use backend\models\UserForm;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['admin', 'gestor', 'funcionario'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
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
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

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
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    public function actionSignup()
    {

        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->createUser()) {

            $auth = Yii::$app->authManager;


            $gestor = $auth->getRole('gestor');
            $funcionario = $auth->getRole('funcionario');
            $cliente = $auth->getRole('cliente');



            // Verifica se o usuário logado tem permissão para criar esta role específica
            if (!Yii::$app->user->can('create' . $model->role)) {
                Yii::$app->session->setFlash('error', 'Você não tem permissão para criar este tipo de conta.');
                return $this->redirect(['site/index']);
            }


            if ($model->createUser()) {
                Yii::$app->session->setFlash('success', 'Utilizador criado com sucesso.');
                return $this->redirect(['site/index']);
            }


        }

        return $this->render('signup', [
            'model' => $model,
        ]);

    }
}
