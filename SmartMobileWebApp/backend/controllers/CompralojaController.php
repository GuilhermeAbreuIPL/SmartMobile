<?php

namespace backend\controllers;

use backend\models\CompraLoja;
use common\models\Loja;
use common\models\Produto;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use backend\models\Fornecedor;
use common\models\ProdutoLoja;

/**
 * CompralojaController implements the CRUD actions for CompraLoja model.
 */
class CompralojaController extends Controller
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
                            'actions' => ['create', 'view', 'index'],
                            'roles' => ['funcionario'],
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
     * Lists all CompraLoja models.
     *
     * @return string
     */
    public function actionIndex($lojaId = null)
    {
        if ($lojaId === null) {
            return $this->render('index', [
                'lojas' => Loja::find()->all(),
                'lojaId' => null,
                'dataProvider' => null,
            ]);
        }

        $produtos = Produto::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => CompraLoja::find()->where(['loja_id' => $lojaId]),
        ]);

        return $this->render('index', [
            'lojas' => Loja::find()->all(),
            'lojaId' => $lojaId,
            'dataProvider' => $dataProvider,
            'produtos' => $produtos,
        ]);

    }

    /**
     * Creates a new CompraLoja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($lojaId)
    {
        $model = new CompraLoja();
        $produtos = Produto::find()->all();
        $fornecedores = Fornecedor::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            // Verificar se o modelo de compra é válido
            if ($model->validate()) {
                // Verificar se o produto já existe na loja e adicionar a quantidade ao stock
                $produtoLoja = ProdutoLoja::findOne(['produto_id' => $model->produto_id, 'loja_id' => $lojaId]);

                if ($produtoLoja) {
                    // Produto já existe na loja, atualizamos o stock
                    $produtoLoja->quantidade += $model->quantidade;
                } else {
                    // Produto ainda não existe na loja, criamos uma nova entrada
                    $produtoLoja = new ProdutoLoja();
                    $produtoLoja->produto_id = $model->produto_id;
                    $produtoLoja->loja_id = $lojaId;
                    $produtoLoja->quantidade = $model->quantidade;
                }

                // Salvar o modelo CompraLoja
                if ($model->save()) {
                    // Salvar o ProdutoLoja
                    if ($produtoLoja->save()) {
                        Yii::$app->session->setFlash('success', 'Compra criada e stock atualizado com sucesso!');
                        return $this->redirect(['index', 'lojaId' => $lojaId]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao atualizar stock.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar a compra.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Erro no form');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'produtos' => $produtos,
            'fornecedores' => $fornecedores,
            'lojaId' => $lojaId,
        ]);
    }




    /**
     * Finds the CompraLoja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CompraLoja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompraLoja::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
