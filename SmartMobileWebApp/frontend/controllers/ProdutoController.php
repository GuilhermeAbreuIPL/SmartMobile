<?php

namespace frontend\controllers;

use common\models\Categoria;
use common\models\Produto;
use common\models\Carrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * ProdutoController handles viewing products and managing the cart.
 */
class ProdutoController extends Controller
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
                            'actions' => ['index', 'view', 'add-to-cart', 'search'],
                            'roles' => ['@'], // Only logged-in users can access
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'search'],
                            'roles' => ['?'], // Guests can view products
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Você não tem permissão para acessar esta página.');
                    },
                ],
            ]
        );
    }

    /**
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find()->with(['produtoPromocao.promocao']),

            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->layout = false;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Produto::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Adds a product to the cart.
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAddToCart($id)
    {
        $produto = Produto::findOne($id);
        if (!$produto) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        $carrinho = Carrinho::findOne(['user_id' => Yii::$app->user->id, 'produto_id' => $id]);

        if ($carrinho) {
            $carrinho->quantidade += 1;
        } else {
            $carrinho = new Carrinho([
                'user_id' => Yii::$app->user->id,
                'produto_id' => $id,
                'quantidade' => 1,
            ]);
        }

        if ($carrinho->save()) {
            Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao adicionar o produto ao carrinho.');
        }

        return $this->redirect(['index']);
    }



    public function actionSearch($search = null, $categoria = null)
    {
        // Query base para os produtos
        $query = Produto::find();

        if ($categoria) {
            // Obter a categoria e suas subcategorias relacionadas
            $categoriaModel = Categoria::findOne($categoria);

            if ($categoriaModel) {
                // Obter todas as categorias relacionadas
                $categoriasIds = $this->getCategoriasRelacionais($categoriaModel->id);

                // Filtrar produtos pela categoria e subcategorias
                $query->andWhere(['categoria_id' => $categoriasIds]);
            }
        }

        if ($search) {
            // Se houver uma categoria, limitar a busca por nome dentro dessa categoria
            $query->andWhere(['like', 'nome', $search]);
        }

        // Obter os resultados
        $produtos = $query->all();

        // Renderizar a view
        return $this->render('search', [
            'produtos' => $produtos,
            'search' => $search,
            'categoria' => $categoria,
        ]);
    }

    /**
     * Função recursiva para obter IDs de todas as categorias relacionadas
     * @param int $categoriaId
     * @return array
     */
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
