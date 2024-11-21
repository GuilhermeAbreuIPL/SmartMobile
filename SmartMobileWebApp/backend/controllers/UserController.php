<?php

namespace backend\controllers;

use backend\models\UserForm;
use backend\models\UserSearch;
use common\models\User;
use common\models\Userprofile;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{
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

    public function actionCreate(){
        $model = new UserForm();


        if ($model->load(\Yii::$app->request->post())) {
            $model->create();
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

        $currentUserRole = array_keys(\Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))[0] ?? null;

        // Restrições de acesso
        if ($currentUserRole === 'funcionario') {
            // Funcionários não podem editar ninguém
            Yii::$app->session->setFlash('error', 'Funcionários não têm permissão para editar utilizadores.');
            $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
            return $this->redirect($lastUrl);
        }

        if ($currentUserRole === 'gestor') {
            // Gestores só podem editar funcionários
            if ($model->role !== 'funcionario') {
                Yii::$app->session->setFlash('error', 'Gestores só podem editar users com a role Funcionário.');
                $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
                return $this->redirect($lastUrl);
            }
        }

        if ($currentUserRole === 'admin') {
            // Admins só podem editar Admin, Gestor e Funcionário
            if (!in_array($model->role, ['admin', 'gestor', 'funcionario'])) {
                Yii::$app->session->setFlash('error', 'Admins só podem editar Admins, Gestores ou Funcionários.');
                $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
                return $this->redirect($lastUrl);
            }
        }

        // Impedir mudanças de role de admin para outro papel
        if ($model->role === 'admin' && $currentUserRole === 'admin') {
            $roles = [
                'admin' => 'Admin', // Admins só podem manter a role como "Admin"
            ];
        } else {
            $roles = $this->getAvailableRoles();
        }

        // Atualizar os dados se forem válidos
        if ($model->load(Yii::$app->request->post()) && $model->update($user, $profile)) {
            Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
            $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
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

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }

        // Obter a role do utilizador atual e do utilizador a ser apagado
        $currentUserRole = array_keys(\Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))[0] ?? null;
        $targetUserRole = array_keys(\Yii::$app->authManager->getRolesByUser($id))[0] ?? null;

        // Restrições de exclusão
        if ($currentUserRole === 'funcionario') {
            Yii::$app->session->setFlash('error', 'Funcionários não têm permissão para apagar utilizadores.');
            $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
            return $this->redirect($lastUrl);
        }

        if ($currentUserRole === 'gestor') {
            if (in_array($targetUserRole, ['admin', 'gestor'])) {
                Yii::$app->session->setFlash('error', 'Gestores não podem apagar Admins ou outros Gestores.');
                $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
                return $this->redirect($lastUrl);
            }
        }

        if ($currentUserRole === 'admin') {
            if ($targetUserRole === 'admin') {
                Yii::$app->session->setFlash('error', 'Admins não podem apagar outros Admins.');
                $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']);
                return $this->redirect($lastUrl);
            }
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

        // Vai para a última página visitada
        $lastUrl = Yii::$app->session->get('lastUrl', ['user/index']); // Default para 'index' se não houver URL
        return $this->redirect($lastUrl);
    }



}
