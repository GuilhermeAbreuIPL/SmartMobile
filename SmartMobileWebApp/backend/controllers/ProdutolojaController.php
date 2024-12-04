<?php

namespace backend\controllers;

use common\models\ProdutoLoja;
use common\models\Loja;
use common\models\Produto;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\BadRequestHttpException;

/**
 * ProdutolojaController implements the CRUD actions for ProdutoLoja model.
 */
class ProdutolojaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['add-stock' , 'index', 'search'],
                            'roles' => ['funcionario'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['remove-stock'],
                            'roles' => ['gestor'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Não tem permissão para ver esta página.');
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ProdutoLoja models.
     *
     * @return string
     */
    public function actionIndex($lojaId = null)
    {
        if ($lojaId === null || $lojaId === '') {
            return $this->render('index', [
                'produtos' => [],
                'lojas' => Loja::find()->all(),
                'lojaId' => null,
                'produtolojas' => null,
            ]);
        }
        $search = Yii::$app->request->get('search', '');

        $produtos = Produto::find()
            ->with(['produtolojas' => function ($query) use ($lojaId) {
                $query->andWhere(['loja_id' => $lojaId]);

            }])
            ->andFilterWhere(['like', 'name', $search])
            ->all();

        $produtolojas = Loja::findOne($lojaId);

        return $this->render('index', [
            'produtos' => $produtos,
            'lojas' => Loja::find()->all(),
            'lojaId' => $lojaId,
            'search' => $search,
            'produtolojas' => $produtolojas,
        ]);
    }



    public function actionAddStock($produtoId, $lojaId)
    {

        $quantidadeAdicionar = Yii::$app->request->post('quantidade', 1);

        // Verificar se já existe um registro para este produto e loja
        $produtoLoja = ProdutoLoja::findOne(['produto_id' => $produtoId, 'loja_id' => $lojaId]);

        if ($produtoLoja) {
            // Produto já existe na loja, atualizamos o stock
            $produtoLoja->quantidade += $quantidadeAdicionar;
        } else {
            // Produto ainda não existe na loja, criamos uma nova entrada
            $produtoLoja = new ProdutoLoja();
            $produtoLoja->produto_id = $produtoId;
            $produtoLoja->loja_id = $lojaId;
            $produtoLoja->quantidade = $quantidadeAdicionar;
        }

        // Salvar no banco de dados
        if ($produtoLoja->save()) {
            Yii::$app->session->setFlash('success', 'Stock atualizado com sucesso');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao atualizar o stock');
        }

        // Redirecionar para a página de índice
        return $this->redirect(['index', 'lojaId' => $lojaId]);
    }

    public function actionRemoveStock($produtoId, $lojaId)
    {
        if (!Yii::$app->user->can('removerStock')) {
            throw new \yii\web\ForbiddenHttpException('Não tens permissão para remover stock');
        }

        $produtoLoja = ProdutoLoja::findOne(['produto_id' => $produtoId, 'loja_id' => $lojaId]);

        if (!$produtoLoja) {
            Yii::$app->session->setFlash('error', 'Produto não encontrado nesta loja.');
            return $this->redirect(['produtoloja/index', 'lojaId' => $lojaId]);
        }

        $quantidade = Yii::$app->request->post('quantidade');
        if ($quantidade <= 0) {
            Yii::$app->session->setFlash('error', 'A quantidade têm de ser maior que zero.');
            return $this->redirect(['produtoloja/index', 'lojaId' => $lojaId]);
        }

        if ($produtoLoja->quantidade < $quantidade) {
            Yii::$app->session->setFlash('error', 'Quantidade Invalida.');
            return $this->redirect(['produtoloja/index', 'lojaId' => $lojaId]);
        }

        $produtoLoja->quantidade -= $quantidade;

        if ($produtoLoja->save()) {
            Yii::$app->session->setFlash('success', 'Stock removido com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao remover stock.');
        }

        return $this->redirect(['produtoloja/index', 'lojaId' => $lojaId]);
    }

    public function actionSearch($lojaId, $search = null)
    {
        // se a pesquisa estiver vazia volta para o index
        if ($search === '') {
            return $this->redirect(['index', 'lojaId' => $lojaId]);
        }

        $query = Produto::find()
            ->with(['produtolojas' => function ($query) use ($lojaId) {
                $query->andWhere(['loja_id' => $lojaId]);
            }]);

        if ($search) {
            $query->andWhere(['like', 'nome', $search]);
        }

        $produtos = $query->all();
        $produtolojas = Loja::findOne($lojaId);

        return $this->render('index', [
            'produtos' => $produtos,
            'lojas' => Loja::find()->all(),
            'lojaId' => $lojaId,
            'produtolojas' => $produtolojas,
            'search' => $search,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ProdutoLoja::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
