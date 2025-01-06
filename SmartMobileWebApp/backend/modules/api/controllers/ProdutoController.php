<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\Categoria;
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


        if(!$produtos){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Não foram encontrados produtos',
            ];
        }

        return [
            'success' => true,
            'produtos' => $produtos
        ];

    }

    public function actionDetalhe($id)
    {

        $produtos = Produto::find()->where(['id' => $id])->with('produtoPromocao.promocao', 'imagem', 'categoria')->asArray()->one();
        if(!$produtos){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'O produto não foi encontrado'
            ];
        }
        return[
            'success' => true,
            'produto' => $produtos
        ];
    }

    public function actionCategorias($id)
    {
        /*
        $produtos = Produto::find()->asArray()->with('imagem')->where(['categoria_id' => $id])->all();
        if(!$produtos){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'Não foram encontrados produtos com a categoria escolhida ou a mesma não existe'
            ];
        }
        return [
            'success' => true,
            'produtos' => $produtos,

        ];
        */
        $ids =  $this->getCategoriasRelacionais($id);
        $produtos = Produto::find()->where(['categoria_id' => $ids])->asArray()->all();

        return[
            $produtos
        ];
    }

    //Function recursiva
    private function getCategoriasRelacionais($categoriaId)
    {
        $ids = [$categoriaId];
        $subcategorias = Categoria::find()->where(['categoria_principal_id' => $categoriaId])->all();

        foreach ($subcategorias as $subcategoria) {
            $ids = array_merge($ids, $this->getCategoriasRelacionais($subcategoria->id));
        }

        return $ids;
    }

}