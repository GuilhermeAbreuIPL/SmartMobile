<?php

namespace frontend\controllers;

use common\models\fatura;
use common\models\MetodoPagamento;
use common\models\Morada;
use common\models\MoradaExpedicao;
use common\models\ProdutoLoja;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;
use yii\helpers\ArrayHelper;
use common\models\Carrinho;
use common\models\LinhaCarrinho;
use common\models\Loja;
use common\models\Produto;
use common\models\LinhaFatura;
use yii\db\Exception;

/**
 * FaturaController implements the CRUD actions for fatura model.
 */
class FaturaController extends Controller
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
                            'actions' => ['index', 'view', 'checkout'],
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

    /**
     * Lists all fatura models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userID = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Fatura::find()->where(['userprofile_id' => $userID]), // Corrigido para usar 'find()' e 'where()'

            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single fatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Carregar a fatura
        $model = $this->findModel($id);

        // Verificar se o utilizador atual é o mesmo que fez a compra
        if ($model->userprofile_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Você não tem permissão para acessar esta página.');
        }

        // Criar o dataProvider para as linhas da fatura
        $dataProvider = new ActiveDataProvider([
            'query' => LinhaFatura::find()->where(['fatura_id' => $model->id]),
            'pagination' => [
                'pageSize' => 10, // Limite de 10 linhas por página
            ],
        ]);

        // Renderizar a view passando os dados
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCheckout()
    {
        // Iniciar uma transação
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // chamar userID
            $userID = Yii::$app->user->id;
            if (!$userID) {
                throw new NotFoundHttpException('User não encontrado.');
            }

            // chamar lojas
            $lojas = Loja::find()->all();
            if (!$lojas) {
                throw new NotFoundHttpException('Lojas não encontradas.');
            }

            // chamar moradas
            $moradas = Morada::findAll(['user_id' => $userID]);

            // chamar carrinho
            $carrinho = Carrinho::findOne(['userprofile_id' => $userID]);
            if (!$carrinho) {
                throw new NotFoundHttpException('Carrinho não encontrado.');
            }

            // chamar métodos de pagamento e converter para array
            $metodopagamento = MetodoPagamento::find()->all();
            $metodopagamentoList = ArrayHelper::map($metodopagamento, 'id', 'nome');
            if (!$metodopagamentoList) {
                throw new NotFoundHttpException('Métodos de pagamento não encontrados.');
            }

            // Atualizar os preços ou remover linhas de produtos inexistentes
            LinhaCarrinho::verificarPrecoProdutos();

            // criar fatura
            $model = new fatura();

            $model->datafatura = date('Y-m-d H:i:s'); // data atual
            $model->userprofile_id = $userID; // user atual
            $model->statusorder = 'Confirmação Pendente'; // status da encomenda

            // calcular preço total do carrinho para guardar na fatura
            $totalPrice = $this->Totalprice();
            if (!$totalPrice) {
                throw new NotFoundHttpException('Carrinho não encontrado.');
            }
            $model->total = $totalPrice;

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    // Verificar se o metodo de pagamento é válido
                    $metodoPagamentoId = $model->metodopagamento_id;
                    if (!MetodoPagamento::findOne($metodoPagamentoId)) {
                        Yii::$app->session->setFlash('error', 'Método de pagamento inválido.');
                        return $this->redirect('checkout');
                    }

                    $tipoEntrega = Yii::$app->request->post('tipoentrega');

                    // Verificar se o tipo de entrega é válido
                    if (!($tipoEntrega === 'morada' || $tipoEntrega === 'loja')) {
                        Yii::$app->session->setFlash('error', 'Tipo de entrega inválido.');
                        return $this->redirect('checkout');
                    }

                    $moradaId = Yii::$app->request->post('morada');
                    $lojaId = Yii::$app->request->post('loja');

                    $expedicao = $this->criarMoradaExpedicao($tipoEntrega, $moradaId, $lojaId);
                    if (!$expedicao) {
                        return $this->redirect('checkout'); // Redireciona em caso de erro
                    }

                    $model->tipoentrega = $tipoEntrega;
                    $model->moradaexpedicao_id = $expedicao->id;

                    // Tenta salvar o modelo
                    if (!$model->save()) {
                        throw new Exception('Erro ao salvar a fatura.');
                    }

                    $confereTransferencia = $this->adicionarProdutosLinhaFatura($carrinho, $model);
                    if (!$confereTransferencia) {
                        Yii::$app->session->setFlash('error', 'Erro ao adicionar produtos à fatura.');
                        return $this->redirect('checkout');
                    } else {
                        // Remover todos os produtos do carrinho
                        LinhaCarrinho::deleteAll(['carrinho_id' => $carrinho->id]);
                    }

                    // Se tudo ocorrer corretamente, confirma a transação
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Compra feita com sucesso.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            $model->loadDefaultValues();
        } catch (\Exception $e) {
            // Reverte a transação em caso de erro
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao processar a compra: ' . $e->getMessage());
            return $this->redirect('checkout');
        }

        return $this->render('checkout', [
            'model' => $model,
            'metodopagamento' => $metodopagamentoList,
            'carrinho' => $carrinho,
            'moradas' => $moradas,
            'lojas' => $lojas,
        ]);
    }


    public function verificarStockLoja($loja_id){
        //chamar userID
        $userID = Yii::$app->user->id;
        //chamar carrinho do user
        $carrinho = Carrinho::findOne(['userprofile_id' => $userID]);
        //chamar linhas do carrinho
        $linhasCarrinho = LinhaCarrinho::findAll(['carrinho_id' => $carrinho->id]);

        //verificar stock de cada produto
        foreach ($linhasCarrinho as $linhaCarrinho){
            $produto = Produto::findOne(['id' => $linhaCarrinho->produto_id]);
            $stock = ProdutoLoja::findOne(['produto_id' => $produto->id, 'loja_id' => $loja_id]);
            if(!$stock || $stock->quantidade < $linhaCarrinho->quantidade){
                return false;
            }
        }
        return true;
    }

    public function removerStockLoja($loja_id){
        //chamar userID
        $userID = Yii::$app->user->id;
        //chamar carrinho do user
        $carrinho = Carrinho::findOne(['userprofile_id' => $userID]);
        //chamar linhas do carrinho
        $linhasCarrinho = LinhaCarrinho::findAll(['carrinho_id' => $carrinho->id]);

        //remover stock de cada produto
        foreach ($linhasCarrinho as $linhaCarrinho){
            $produto = Produto::findOne(['id' => $linhaCarrinho->produto_id]);
            $stock = ProdutoLoja::findOne(['produto_id' => $produto->id, 'loja_id' => $loja_id]);
            $stock->quantidade -= $linhaCarrinho->quantidade;
            $stock->save();
        }
    }

    public function adicionarProdutosLinhaFatura($carrinho, $fatura){
        //chamar linhas do carrinho
        $linhasCarrinho = LinhaCarrinho::findAll(['carrinho_id' => $carrinho->id]);

        //passar dados
        foreach ($linhasCarrinho as $linhaCarrinho){
            $linhaFatura = new LinhaFatura();
            $linhaFatura->fatura_id = $fatura->id;
            $linhaFatura->produto_id = $linhaCarrinho->produto_id;
            $linhaFatura->quantidade = $linhaCarrinho->quantidade;
            $linhaFatura->precounitario = $linhaCarrinho->precounitario;
            $linhaFatura->save();
        }

        //verificar se as linhas fatura foram adicionadas
        $linhasFatura = LinhaFatura::findAll(['fatura_id' => $fatura->id]);
        if(!$linhasFatura){
            return false;
        }

        return true;
    }

    public static function Totalprice()
    {
        $userId = Yii::$app->user->id;
        $carrinho = Carrinho::findOne(['userprofile_id' => $userId]);

        if (!$carrinho) {
            throw new yii\web\NotFoundHttpException('Carrinho não encontrado.');
        }

        $totalPrice = 0;
        foreach ($carrinho->linhacarrinhos as $linhaCarrinho) {
            $totalPrice += $linhaCarrinho->quantidade * $linhaCarrinho->precounitario;
        }

        return $totalPrice;
    }

    private function criarMoradaExpedicao($tipoEntrega, $moradaId, $lojaId) {
        if ($tipoEntrega === 'morada') {
            // Não precisa verificar o estoque para entrega em morada
            $morada = Morada::findOne($moradaId);
            if (!$morada) {
                throw new NotFoundHttpException('Morada selecionada inválida.');
            }

            $expedicao = new MoradaExpedicao();
            $expedicao->rua = $morada->rua;
            $expedicao->localidade = $morada->localidade;
            $expedicao->codpostal = $morada->codpostal;

        } elseif ($tipoEntrega === 'loja') {

            $loja = Loja::findOne($lojaId);
            if (!$loja) {
                throw new NotFoundHttpException('Loja selecionada inválida.');
            }

            if (!$this->verificarStockLoja($lojaId)) {
                Yii::$app->session->setFlash('error', 'Stock insuficiente de produto(s) na loja selecionada.');
                return null; // Retorna null em caso de erro
            }

            // Remove o stock da loja
            $this->removerStockLoja($lojaId);

            $expedicao = new MoradaExpedicao();
            $expedicao->rua = $loja->rua;
            $expedicao->localidade = $loja->localidade;
            $expedicao->codpostal = $loja->codpostal;

        } else {
            Yii::$app->session->setFlash('error', 'Tipo de entrega inválido.');
            return null; // Retorna null se o tipo de entrega for inválido
        }

        if (!$expedicao->save()) {
            Yii::$app->session->setFlash('error', 'Erro ao criar morada de expedição.');
            return null;
        }

        return $expedicao;
    }

    /**
     * Finds the fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
