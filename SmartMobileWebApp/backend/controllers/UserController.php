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

    public function actionCreate(){
        $model = new UserForm();


        if ($model->load(\Yii::$app->request->post())) {
            $model->create();
            return $this->redirect(['site/index']);
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

        //chamar os cenarios
        $user->scenario = 'update';
        $profile->scenario = 'update';

        $model = new UserForm();
        $model->setAttributes(array_merge($user->attributes, $profile->attributes));
        $model->role = \Yii::$app->authManager->getRolesByUser($id)
            ? array_keys(\Yii::$app->authManager->getRolesByUser($id))[0]
            : null;

        //ele chega aqui mas o model update vem null
        if ($model->load(\Yii::$app->request->post()) && $model->update($user, $profile)) {
            return $this->redirect(['user/index']);
        }


        $roles = $this->getAvailableRoles();

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

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $auth = \Yii::$app->authManager;
            $auth->revokeAll($user->id);

            if (!$profile->delete()) {
                throw new \Exception('Erro ao apagar Userprofile.');
            }

            if (!$user->delete()) {
                throw new \Exception('Erro ao apagar User.');
            }

            $transaction->commit();
            \Yii::$app->session->setFlash('success', 'Utilizador apagado com sucesso.');
        } catch (\Exception $e) {
            $transaction->rollBack(); 
            \Yii::$app->session->setFlash('error', 'Erro ao apagar o utilizador: ' . $e->getMessage());
        }

        return $this->redirect(['user/index']);
    }

}
