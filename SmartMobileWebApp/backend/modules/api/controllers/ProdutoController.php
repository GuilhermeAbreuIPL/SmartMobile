<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\LoginForm;
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


class ProdutoController extends Controller
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

    //TODO: Desenvolver outras funcionalidades.

    public function actionProdutos()
    {

        //$produtos = Produto::find()->asArray()->with('imagem')->all();
        //$promocaoProduto = ProdutoPromocao::findAll();
        $produtos = Produto::find()->with(['produtoPromocao.promocao', "imagem"])->asArray()->all();
        //TODO: Adicionar disponibilidade de produtos por loja se necessário.

        return [
            $produtos
        ];

    }

    public function actionDetalhe($id)
    {
        $produto = Produto::findOne($id);
        $imagem = $produto->imagem;
        $promocao = $produto->produtoPromocao->promocao;
        $campanha = $produto->produtoPromocao;

        //$promocao = $produto->produtoPromocaos;

        return [
            $produto,
            $imagem,
            $promocao,
            $campanha,
        ];
    }

    public function actionCategorias($id)
    {
        //TODO: Descobrir como fazer a query recursivamente. De forma a que se a categoria selecionada for telemoveis aparecam todos.

        $produtos = Produto::find()->asArray()->with('imagem')->where(['categoria_id' => $id])->all();
        return [
            $produtos,
        ];
    }


}