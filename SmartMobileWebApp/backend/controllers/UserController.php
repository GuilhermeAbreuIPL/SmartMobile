<?php

namespace backend\controllers;

use backend\models\UserForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate(){
        $model = new UserForm();


        if ($model->load(\Yii::$app->request->post())) {
            $model->create();
            return $this->redirect(['site/index']);
        }

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
        } elseif (Yii::$app->user->can('createcliente')){
            $roles = [
                'cliente' => 'Cliente'
            ];
        }

            return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

}
