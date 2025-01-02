<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\Carrinho;
use common\models\LinhaCarrinho;
use common\models\LoginForm;
use common\models\Produto;
use common\models\UserForm;
use common\models\Userprofile;
use Yii;
use yii\debug\models\search\Profile;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use common\models\Morada;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class CarrinhoController extends Controller
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

    //

    public function actionAdicionarItem($id)
    {

        $carrinhoCreated = false;
        $request = Yii::$app->request;
        //Obeter o user através do token
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        //Primeiro encontrar o produto.
        $produto = Produto::findOne($id);
        if(!$produto){
            //TODO: Devolver erro produto n existe.
            return 'produto n encontrado';
        }

        //Procura o carrinho!
        $carrinho = Carrinho::findOne(['userprofile_id' => $user->id]);

        //Se o carrinho não existir criar o carrinho novo.
        if(!$carrinho){
            $carrinho = new Carrinho();
            $carrinho->datacriacao = date('Y-m-d H:i:s');
            $carrinho->userprofile_id = $user->id;
            $carrinho->save();
            $carrinhoCreated = true;
        }

        $linhaCarrinho = LinhaCarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $id]);

        if(!$linhaCarrinho){
            //Criar linha carrinho
            $linhaCarrinho = new LinhaCarrinho();
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->precounitario = $produto->preco;
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $id;
            $linhaCarrinho->save();
            return [
                'message' =>'Adicionei um produto novo ao carrinho',
                'carrinhoCreated' => $carrinhoCreated
            ];
        }

        //Adição de quantidade.

        $linhaCarrinho->quantidade += 1;
        //Chama função que verifica os preços e muda os mesmos se necessário.
        $linhaCarrinho->save();
        return [
            'message' => 'Adicionei um produto já existente ao carrinho +=1 quantidade',
            'carrinhoCreated' => $carrinhoCreated
        ];





    }

}