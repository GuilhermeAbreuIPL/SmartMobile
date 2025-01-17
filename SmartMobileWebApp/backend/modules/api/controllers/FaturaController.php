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

        foreach ($faturas as $fatura) {
            $data = [
                'id' => $fatura->id,
                'data' => $fatura->datafatura,
                'total' => $fatura->total,
                'estado' => $fatura->statusorder,
                'metodopagamento' => $fatura->metodopagamento->nome,
            ];

            $faturadata[] = $data;
        }


        if(!$faturas){
            Yii::$app->response->statusCode = 404;
            return[
                'success'=> false,
                'message' => 'Não foi encontrado nenhuma fatura'
            ];
        }

        return [
            'success' => true,
            'faturas' => $faturadata
        ];

    }

    public function actionDetalhes($id)
    {
        $request = YII::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParams('access-token'));
        $fatura = Fatura::find()->where(['userprofile_id'=> $user->id, 'id' => $id] )->with(['linhafaturas.produto.imagem','moradaexpedicao', 'metodopagamento'])->one();
        if(!$fatura){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'O utilizador não tem faturas',
            ];
        }

        //return $faturas com data, total, estado, metodo de pagamento, morada de expedicao, tipo entrega, linhasfaturas com produto, quantidade, preco

        foreach ($fatura->linhafaturas as $linhafatura) {
            $data = [
                'produto' => $linhafatura->produto->nome,
                'quantidade' => $linhafatura->quantidade,
                'preco' => $linhafatura->precounitario,
            ];

            $linhafaturadata[] = $data;
        }

        
        $data = [
            'data' => $fatura->datafatura,
            'total' => $fatura->total,
            'estado' => $fatura->statusorder,
            'metodopagamento' => $fatura->metodopagamento->nome,
            'tipoentrega' => $fatura->tipoentrega,
            'rua' => $fatura->moradaexpedicao->rua,
            'localidade' => $fatura->moradaexpedicao->localidade,
            'codpostal' => $fatura->moradaexpedicao->codpostal,
            'linhafaturas' => $linhafaturadata
        ];

        return[
            'success' => true,
            'faturas' => $data
        ];
    }




}