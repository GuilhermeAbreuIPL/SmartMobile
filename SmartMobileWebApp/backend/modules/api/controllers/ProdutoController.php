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

        //Funcionava com o comment abaixo
        //$produtos = Produto::find()->with(['produtoPromocao.promocao', "imagem"])->asArray()->all();
        $produtos = Produto::find()->all();

        if(!$produtos){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Não foram encontrados produtos',
            ];
        }

        foreach($produtos as $produto){
            $precoPromo = $produto->preco;
            if($produto->produtoPromocao != null){
                $precoPromo = $precoPromo - ($precoPromo * $produto->produtoPromocao->promocao->descontopercentual / 100);
            }else{
                $precoPromo = null;
            }
            
            $produtoInfo = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'categoria' => $produto->categoria->nome,
                'categoria_id' => $produto->categoria_id,
                'filename' => $produto->imagem->filename,
                'preco' => $produto->preco,
                'precoPromo' => $precoPromo,
                'descricao' => $produto->descricao,
            ];

            $data[] = $produtoInfo;
        }

        return [
            'success' => true,
            'produtos' => $data
            //'produtos' => $produtos
        ];

    }

    public function actionDetalhe($id)
    {

        //$produtos = Produto::find()->where(['id' => $id])->with('produtoPromocao.promocao', 'imagem', 'categoria')->asArray()->one();
        $produtos = Produto::find()->where(['id' => $id])->one();
        if(!$produtos){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'O produto não foi encontrado'
            ];
        }
        
        $precoPromo = $produtos->preco;
            if($produtos->produtoPromocao != null){
                $precoPromo = $precoPromo - ($precoPromo * $produtos->produtoPromocao->promocao->descontopercentual / 100);
            }else{
                $precoPromo = null;
            }

        $produtoInfo = [
            'id' => $produtos->id,
            'nome' => $produtos->nome,
            'categoria' => $produtos->categoria->nome,
            'categoria_id' => $produtos->categoria_id,
            'filename' => $produtos->imagem->filename,
            'preco' => $produtos->preco,
            'precoPromo' => $precoPromo,
            'descricao' => $produtos->descricao,
        ];

        return[
            'success' => true,
            'produto' => $produtoInfo
            //'produto' => $produtos
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