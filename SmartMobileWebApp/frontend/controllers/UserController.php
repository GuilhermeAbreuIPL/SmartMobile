<?php

namespace frontend\controllers;

use common\models\User;
use common\models\UserForm;
use common\models\Userprofile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Morada;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'update', 'delete', 'manage-morada', 'delete-morada'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
                },
            ],
        ];
    }

    public function actionView()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);
        $profile = Userprofile::findOne(['id' => $userId]);

        $moradas = Morada::find()->where(['user_id' => $userId])->all();

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }

        return $this->render('view', [
            'user' => $user,
            'profile' => $profile,
            'moradas' => $moradas,
        ]);
    }

    public function actionUpdate()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);
        $profile = Userprofile::findOne(['id' => $userId]);

        if ($user === null || $profile === null) {
            throw new \yii\web\NotFoundHttpException('Usuário ou perfil não encontrado.');
        }

        $profile->scenario = 'update';
        $model = new UserForm();

        // Inclui a role atual do usuário
        $roles = Yii::$app->authManager->getRolesByUser($userId);
        $currentRole = reset($roles);
        $model->role = $currentRole ? $currentRole->name : null;


        $model->setAttributes(array_merge($user->attributes, $profile->attributes));

        if ($model->load(Yii::$app->request->post()) && $model->update($user, $profile)) {
            Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $userId]);
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $user,
            'profile' => $profile,
        ]);
    }


    public function actionDelete()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);
        $profile = Userprofile::findOne(['id' => $userId]);

        if (!$user || !$profile) {
            throw new NotFoundHttpException('Utilizador não encontrado.');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $auth = Yii::$app->authManager;
            $auth->revokeAll($userId);

            if (!$profile->delete() || !$user->delete()) {
                throw new \Exception('Erro ao apagar utilizador.');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Conta apagada com sucesso.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Erro ao apagar a conta: ' . $e->getMessage());
        }

        return $this->redirect(['site/index']); // Redireciona após a conta ser apagada
    }


    public function actionManageMorada($moradaId = null)
    {
        $userId = Yii::$app->user->id;

        if ($moradaId) {
            $model = Morada::findOne(['id' => $moradaId, 'user_id' => $userId]);
            if (!$model) {
                throw new NotFoundHttpException('Morada não encontrada ou não pertence a este utilizador.');
            }
        } else {
            $model = new Morada();
        }

        if ($model->isNewRecord && Morada::find()->where(['user_id' => $userId])->count() >= 3) {
            Yii::$app->session->setFlash('error', 'Você só pode ter no máximo 3 moradas.');
            return $this->redirect(['user/view']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->user_id = $userId;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Morada salva com sucesso.');
                return $this->redirect(['user/view']);
            }
        }

        return $this->render('manage-morada', [
            'model' => $model,
        ]);
    }

    public function actionDeleteMorada($moradaId)
    {
        $userId = Yii::$app->user->id;

        $model = Morada::findOne(['id' => $moradaId, 'user_id' => $userId]);

        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Morada apagada com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Morada não encontrada ou não pertence a este utilizador.');
        }

        return $this->redirect(['user/view']);
    }

}
