<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
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


class MetodoController extends Controller
{
    /*
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(), //Antes era queryparam
            //'except' => ['register' , 'login']
        ];

        return $behaviors;
    }
    */



    public function actionShow()
    {
        $metodoPagameto = MetodoPagamento::find()->all();
        if(!$metodoPagameto){
            Yii::$app->response->statusCode = 404;
            return[
                'success'=> false,
                'message' => 'Não foi encontrado nenhum metodo de pagamento'
            ];
        }

        return [
            'success' => true,
            'metodoPagamento' => $metodoPagameto
        ];

    }




}