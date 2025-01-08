<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\Fatura;
use common\models\LoginForm;
use common\models\MetodoPagamento;
use common\models\Produto;
use common\models\ProdutoPromocao;
use common\models\UserForm;
use common\models\Userprofile;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use yii\rest\Controller;
use yii\web\Response;


class FaturaController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(), //Antes era queryparam
            //'except' => ['register' , 'login']
        ];

        return $behaviors;
    }




    public function actionShow()
    {
        $request = YII::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParams('access-token'));
        $faturas = Fatura::find()->where(['userprofile_id' => $user->id])->all();

        if(!$faturas){
            Yii::$app->response->statusCode = 404;
            return[
                'success'=> false,
                'message' => 'Não foi encontrado nenhuma fatura'
            ];
        }

        return [
            'success' => true,
            'faturas' => $faturas
        ];

    }

    public function actionDetalhes($id)
    {
        $request = YII::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParams('access-token'));
        $faturas = Fatura::find()->where(['userprofile_id'=> $user->id, 'id' => $id] )->with(['linhafaturas.produto.imagem','moradaexpedicao', 'metodopagamento'])->asArray()->all();
        if(!$faturas){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'O utilizador não tem faturas',
            ];
        }




        return[
            'success' => true,
            'faturas' => $faturas
        ];
    }




}