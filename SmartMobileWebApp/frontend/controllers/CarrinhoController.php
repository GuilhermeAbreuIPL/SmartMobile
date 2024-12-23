<?php

namespace frontend\controllers;

use common\models\linhacarrinho;
use common\models\Produto;
use common\models\Carrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoController implements the CRUD actions for linhacarrinho model.
 */
class CarrinhoController extends Controller
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
                            'actions' => ['index', 'view', 'add', 'remove'],
                            'roles' => ['@'], // Only logged-in users can access
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Você não tem permissão para acessar esta página.');
                    },
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $carrinho = Carrinho::findOne(['userprofile_id' => $userId]);

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        // Atualiza preços ou remove linhas de produtos inexistentes
        LinhaCarrinho::verificarPrecoProdutos();

        return $this->render('index', [
            'carrinho' => $carrinho,
        ]);
    }

    public function actionView()
    {
        $userId = Yii::$app->user->id;
        $carrinho = Carrinho::findOne(['userprofile_id' => $userId]);

        $this->layout = false;

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        // Atualiza preços ou remove linhas de produtos inexistentes
        LinhaCarrinho::verificarPrecoProdutos();

        return $this->render('view', [
            'carrinho' => $carrinho,
        ]);
    }


    public function actionAdd($id)
    {
        $userId = Yii::$app->user->id;
        $produto = Produto::findOne($id);

        if (!$produto) {
            throw new NotFoundHttpException('Produto não encontrado.');
        }

        $carrinho = Carrinho::findOne(['userprofile_id' => $userId]);
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->datacriacao = date('Y-m-d H:i:s');
            $carrinho->userprofile_id = $userId;
            $carrinho->save();
        }

        $linhaCarrinho = LinhaCarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $id]);
        if ($linhaCarrinho) {
            if ($linhaCarrinho->precounitario != $produto->preco) {
                $linhaCarrinho->delete();
                $linhaCarrinho = new LinhaCarrinho();
                $linhaCarrinho->quantidade = 1;
                $linhaCarrinho->precounitario = $produto->preco;
                $linhaCarrinho->carrinho_id = $carrinho->id;
                $linhaCarrinho->produto_id = $id;
                $linhaCarrinho->save();
            } else {
                $linhaCarrinho->quantidade += 1;
                $linhaCarrinho->save();
            }
        } else {
            $linhaCarrinho = new LinhaCarrinho();
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->precounitario = $produto->preco;
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $id;
            $linhaCarrinho->save();
        }

        return $this->redirect(['index']);
    }

    public function actionRemove($id)
    {
        $userId = Yii::$app->user->id;
        $carrinho = Carrinho::findOne(['userprofile_id' => $userId]);

        if (!$carrinho) {
            throw new NotFoundHttpException('Carrinho não encontrado.');
        }

        $linhaCarrinho = LinhaCarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $id]);

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade -= 1;
            if ($linhaCarrinho->quantidade <= 0) {
                $linhaCarrinho->delete();
            } else {
                $linhaCarrinho->save();
            }
        }

        return $this->redirect(['index']);
    }

}
