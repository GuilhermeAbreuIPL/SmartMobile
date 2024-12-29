<?php

namespace backend\controllers;

use backend\models\UserSearch;
use common\models\User;
use common\models\UserForm;
use common\models\Userprofile;
use common\models\Morada;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Regra para ações relacionadas à gestão de users
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        'roles' => ['admin', 'gestor'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'moradas'],
                        'roles' => ['admin', 'gestor', 'funcionario'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        //encontrar dados do user e user profile
        $user = User::findOne($id);
        $profile = Userprofile::findOne(['id' => $id]);

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }

        //encontrar dados sobre a role do user
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRolesByUser($id);
        $role = !empty($roles) ? reset($roles)->name : 'Sem Role';

        return $this->render('view', [
            'user' => $user,
            'profile' => $profile,
            'role' => $role,
        ]);
    }

    public function actionMoradas($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        if (!$user->moradas) {
            Yii::$app->session->setFlash('error', 'Este user não tem moradas associadas.');
            return $this->redirect(Yii::$app->session->get('lastUrl', ['user/index']));
        }

        $moradas = $user->moradas;

        return $this->render('moradas', [
            'user' => $user,
            'moradas' => $moradas,
        ]);
    }
    public function actionCreate(){
        $model = new UserForm();



        if ($model->load(\Yii::$app->request->post())) {
            $model->create();
            Yii::$app->session->setFlash('success', 'Utilizador criado com sucesso!');
            return $this->redirect(['user/index']);
        }

            $roles = $this->getAvailableRoles();

            return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $profile = Userprofile::findOne(['id' => $id]);

        // Guarda que este foi o último URL
        $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }

        // Cenários
        $user->scenario = 'update';
        $profile->scenario = 'update';

        $model = new UserForm();
        $model->setAttributes(array_merge($user->attributes, $profile->attributes));
        $model->role = \Yii::$app->authManager->getRolesByUser($id)
            ? array_keys(\Yii::$app->authManager->getRolesByUser($id))[0]
            : null;

        // Obter a role do user a ser editado
        $targetUserRole = array_keys(\Yii::$app->authManager->getRolesByUser($id))[0] ?? null;

        /*
        // Verifica se o user tem uma role atribuída
        if (!$targetUserRole) {
            Yii::$app->session->setFlash('error', 'O user não tem uma role atribuída.');
            return $this->redirect($lastUrl);
        }*/

        // Permissões para editar
        $permissions = [
            'funcionario' => 'updateFuncionario',
            'gestor' => 'updateGestor',
        ];

        // Verificar permissão
        if (isset($permissions[$targetUserRole]) && !Yii::$app->user->can($permissions[$targetUserRole])) {
            Yii::$app->session->setFlash('error', "Não tens permissão para editar a role {$targetUserRole}.");
            return $this->redirect($lastUrl);
        }

        if ($targetUserRole === 'admin' || $targetUserRole === 'cliente') {
            Yii::$app->session->setFlash('error', 'O cliente e o admin não podem ser editados.');
            return $this->redirect($lastUrl);
        }

        $roles = $this->getAvailableRoles();

        // Atualizar os dados se forem válidos
        if ($model->load(Yii::$app->request->post()) && $model->update($user, $profile)) {
            Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
            return $this->redirect($lastUrl);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }




    protected function getAvailableRoles()
    {
        $roles = [];
        if (Yii::$app->user->can('creategestor')) {
            $roles = [
                'gestor' => 'Gestor',
                'funcionario' => 'Funcionario',
                'cliente' => 'Cliente'
            ];
        } elseif (Yii::$app->user->can('createfuncionario')) {
            $roles = [
                'funcionario' => 'Funcionario',
                'cliente' => 'Cliente'
            ];
        } elseif (Yii::$app->user->can('createcliente')) {
            $roles = [
                'cliente' => 'Cliente'
            ];
        }
        return $roles;
    }



    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
        $profile = Userprofile::findOne(['id' => $id]);

        // Guarda que este foi o ultimo url
        $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }


        $targetUserRole = array_keys(\Yii::$app->authManager->getRolesByUser($id))[0] ?? null;
        /*
        //ve se existe uma role atribuida ao user
        if (!$targetUserRole) {
            Yii::$app->session->setFlash('error', 'O user não tem uma role atribuída.');
            return $this->redirect($lastUrl);
        }*/

        // Verificar permissões
        $permissions = [
            'cliente' => 'deleteCliente',
            'funcionario' => 'deleteFuncionario',
            'gestor' => 'deleteGestor',
        ];

        if (isset($permissions[$targetUserRole]) && !Yii::$app->user->can($permissions[$targetUserRole])) {
            Yii::$app->session->setFlash('error', "Não tens permissão para apagar a role {$targetUserRole}.");
            return $this->redirect($lastUrl);
        }

        // Caso para Admin
        if ($targetUserRole === 'admin') {
            Yii::$app->session->setFlash('error', 'Admins não podem ser apagados.');
            return $this->redirect($lastUrl);
        }

        // Iniciar transação para apagar o utilizador
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            // Revogar todas as permissões do utilizador
            $auth = \Yii::$app->authManager;
            $auth->revokeAll($user->id);

            // Apagar o perfil do utilizador
            if (!$profile->delete()) {
                throw new \Exception('Erro ao apagar Userprofile.');
            }

            // Apagar o utilizador
            if (!$user->delete()) {
                throw new \Exception('Erro ao apagar User.');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Utilizador apagado com sucesso.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao apagar o utilizador: ' . $e->getMessage());
        }

        return $this->redirect($lastUrl);
    }

}
