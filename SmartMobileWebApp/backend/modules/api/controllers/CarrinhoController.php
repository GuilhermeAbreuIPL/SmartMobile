<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\Carrinho;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\LoginForm;
use common\models\Loja;
use common\models\MetodoPagamento;
use common\models\MoradaExpedicao;
use common\models\Produto;
use common\models\UserForm;
use common\models\Userprofile;
use common\models\ProdutoLoja;
use common\models\LinhaFatura;
use Yii;
use yii\db\Exception;
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

        $request = Yii::$app->request;
        //Obeter o user através do token
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        //Primeiro encontrar o produto.
        $produto = Produto::findOne($id);
        if(!$produto){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'mensagem' => 'O id do produto que está a tentar adicionar ao carrinho não existe.'
            ];
        }

        //Procura o carrinho!
        $carrinho = Carrinho::findOne(['userprofile_id' => $user->id]);

        //Se o carrinho não existir criar o carrinho novo.
        if(!$carrinho){
            $carrinho = new Carrinho();
            $carrinho->datacriacao = date('Y-m-d H:i:s');
            $carrinho->userprofile_id = $user->id;
            $carrinho->save();
        }

        $linhaCarrinho = LinhaCarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $id]);

        if(!$linhaCarrinho){
            //Resposta se a linhaCarrinho n existe.
            $linhaCarrinho = new LinhaCarrinho();
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->precounitario = $produto->preco;
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $id;
            $linhaCarrinho->save();
            return [
                'success' => true,
                'message' => 'O item foi adicionado ao carrinho!',
                'linhacarrinho' => $linhaCarrinho,

            ];
        }



        $linhaCarrinho->quantidade += 1;
        //TODO: Chamar uma função que atualize / verifique os preços do carrinho (Modelo LinhaCarrinho ou Carrinho)
        $linhaCarrinho->save();
        return [
            'success'=> true,
            'message'=> 'O item já existia no carrinho, quantidade atualizada.',
            'linhacarrinho' => $linhaCarrinho
        ];





    }

    public function actionAtualizarQuantidade($id){
        
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        $linhacarrinho = LinhaCarrinho::findOne($id);


        if(!$linhacarrinho){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'Linha de carrinho a atualizar não existe.'
            ];
        }

        $quantidade = $request->post('quantidade');
        if($quantidade == null){
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'A quantidade tem de estar preenchida',
            ];
        }

        if(!is_numeric($quantidade)){
            Yii::$app->response->statusCode = 400;
            return[
                'success' => false,
                'message' => 'A quantidade tem de ser um número',
            ];
        }

        if($quantidade < 0){
            Yii::$app->response->statusCode = 400;
            return[
                'success' => false,
                'error' => 'A quantidade não pode ser menor que 0'
            ];
        }

        if($quantidade == 0){
            $linhacarrinho->delete();
            return[
                'success' => true,
                'message' => 'A quantidade foi alterada para 0 logo o item foi removido'
            ];
        }

        $linhacarrinho->quantidade = $quantidade;
        $linhacarrinho->save();
        return[
            'success' => true,
            'message' => 'A quantidade foi mudada com sucesso!',
            'linhacarrinho' => $linhacarrinho
        ];

    }

    //Função que podia estar no carrinho ou nas faturas?

    public function actionCheckout()
    {
        /*
            1 - Adicionar ao carrinho
            2 - Finalizar Compra
            3 - Escolher uma das estaticas no android -> levantamento em loja ou entrega
            4 - Get Moradas.
            5 - Get Loja.

         */
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        $carrinho = Carrinho::findOne(['userprofile_id' => $user->id]);
        if(!$carrinho){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Carrinho não encontrado',
            ];
        }
        $linhascarrinho = $carrinho->linhacarrinhos;
        if(!$linhascarrinho){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Não existem items no carrinho'
            ];
        }


        $tipoEntrega = $request->post('tipoEntrega');
        $metodoPagamentoId = $request->post('metodoPagamento');

        if(!$metodoPagamentoId || !is_numeric($metodoPagamentoId)){
            Yii::$app->response->statusCode = 400;
            return[
                'success' => false,
                'message' => 'Metodo de pagamento (metodoPagamento) tem de ser preenchido.'
            ];
        }

        $metodoPagamento = MetodoPagamento::findOne($metodoPagamentoId);

        if(!$metodoPagamento){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'Metodo pagamento inserido não foi encontrado'
            ];
        }



        //Criar Fatura.
        $transaction = Yii::$app->db->beginTransaction();
        try{
            //Preencher cabeçalho da Fatura
            $fatura = new Fatura();
            $fatura->userprofile_id = $user->id;
            $fatura->metodopagamento_id = $metodoPagamento->id;
            $fatura->datafatura = date('Y-m-d H:i:s');
            $fatura->statusorder = 'Confirmação Pendente';
            $fatura->save(false);



            switch ($tipoEntrega){
                case 'Morada':
                    $fatura->tipoentrega = 'Morada';
                    //verifica tipo entrega para alem de verificar também cria morada expedição
                    $result = $this->verificaTipoEntrega('Morada' ,$request, $user->id);
                    if ($result['success'] == false){
                        $transaction->rollBack();
                        return [
                            'success' => false,
                            'message' => $result['error']
                        ];
                    }

                    $fatura->moradaexpedicao_id = $result['moradaexpedicao_id'];
                    $fatura->save(false);

                    $totalPrice = 0;
                    foreach ($linhascarrinho as $linha){
                        $linhaFatura = new LinhaFatura();
                        $linhaFatura->fatura_id = $fatura->id;
                        $linhaFatura->produto_id = $linha->produto_id;
                        $linhaFatura->quantidade = $linha->quantidade;
                        $linhaFatura->precounitario = $linha->precounitario;
                        $linhaFatura->save(false);

                        //Preço total da fatura
                        $produto = Produto::findOne($linha->produto_id);
                        if ($produto) {
                            $precoPromo = $produto->preco;
                            if($produto->produtoPromocao != null){
                                $precoPromo = $precoPromo - ($precoPromo * $produto->produtoPromocao->promocao->descontopercentual / 100);
                                $linhaFatura->precounitario = $precoPromo;
                                $linhaFatura->save(false);
                                $totalPrice += ($precoPromo * $linha->quantidade);
                            }else{
                                $precoPromo = null;
                                $totalPrice += ($produto->preco * $linha->quantidade);
                            }
                        }
                    }


                    LinhaCarrinho::deleteAll(['carrinho_id' => $carrinho->id]);
                    $fatura->total = $totalPrice;
                    $fatura->save(false);
                    $transaction->commit();
                    return [
                        'success' => true,
                        'fatura' => $fatura
                    ];
                    break;

                case 'Loja':
                    $fatura->tipoentrega = 'Loja';
                    $result = $this->verificaTipoEntrega('Loja' ,$request);
                    if ($result['success'] == false){
                        $transaction->rollBack();
                        Yii::$app->response->statusCode = 404;
                        return [
                            'success' => false,
                            'message' => $result['error']
                        ];
                    }
                    $fatura->moradaexpedicao_id = $result['moradaexpedicao_id'];
                    $fatura->save(false);

                    $stockDisponivel = true;
                    foreach($linhascarrinho as $linha){
                        $produto = Produto::findOne(['id' => $linha->produto_id]);
                        $stock = ProdutoLoja::findOne(['produto_id' => $produto->id, 'loja_id' => $result['loja_id']]);
                        if(!$stock || $stock->quantidade < $linha->quantidade){
                            $stockDisponivel = false;
                            break;
                        }
                    }

                    if(!$stockDisponivel){
                        $transaction->rollBack();
                        Yii::$app->response->statusCode = 409;
                        return[
                            'success' => false,
                            'message' => 'Stock Indisponivel num dos items tente diminuir a quantidade.'
                        ];
                    }

                    //remover stock.
                    foreach ($linhascarrinho as $linha){
                        $produto = Produto::findOne(['id' => $linha->produto_id]);
                        $stock = ProdutoLoja::findOne(['produto_id' => $produto->id, 'loja_id' => $result['loja_id']]);
                        $stock->quantidade -= $linha->quantidade;
                        $stock->save(false);
                    }

                    //adicionar linha fatura
                    foreach ($linhascarrinho as $linha){
                        $linhaFatura = new LinhaFatura();
                        $linhaFatura->fatura_id = $fatura->id;
                        $linhaFatura->produto_id = $linha->produto_id;
                        $linhaFatura->quantidade = $linha->quantidade;
                        $linhaFatura->precounitario = $linha->precounitario;
                        $linhaFatura->save(false);
                    }

                    $totalPrice = 0;
                    foreach ($linhascarrinho as $linha) {
                        $totalPrice += $linha->quantidade * $linha->precounitario;
                    }

                    LinhaCarrinho::deleteAll(['carrinho_id' => $carrinho->id]);
                    $fatura->total = $totalPrice;
                    $fatura->save(false);
                    $transaction->commit();
                    return [
                        'success' => true,
                        'fatura' => $fatura
                    ];
                    break;
                default:
                    $transaction->rollBack();
                    return[
                        'success' => false,
                        'message' => 'Tipo de entrega tem de ser Morada ou Loja'
                    ];
            }

        }catch (\Exception $e){
            $transaction->rollBack();
            Yii::$app->response->statusCode = 500;
            return[
                'success' => false,
                'message' => 'Um erro inesperado aconteceu:'. $e
            ];

        }






    }

    public function actionRemoverItem($id)
    {
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        $linhacarrinho = LinhaCarrinho::findOne($id);
        if(!$linhacarrinho){
            Yii::$app->response->statusCode = 404;
            return[
                'success' => false,
                'message' => 'Linha carrinho não encontrada.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Linha carrinho removida com sucesso'
        ];
    }

    public function actionCarrinho(){
        $request = YII::$app->request;
        $user = User::findIdentityByAccessToken($request->getQueryParam('access-token'));
        //$carrinho = Carrinho::find()->where(['userprofile_id' => $user->id])->with(['linhacarrinhos.produto.imagem'])->asArray()->all();
        $carrinho = Carrinho::find()->where(['userprofile_id' => $user->id])->one();

        $linhacarrinho = LinhaCarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        $total = 0;

        if(!$carrinho){
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Carrinho do utilizador não encontrado',
            ];
        }

        
        $linhasCarrinho = LinhaCarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

    $linhasFormatadas = [];

    

    foreach ($linhasCarrinho as $linha) {
        $produto = Produto::findOne($linha->produto_id);

        if ($produto) {
            $precoPromo = $produto->preco;
            if($produto->produtoPromocao != null){
                $precoPromo = $precoPromo - ($precoPromo * $produto->produtoPromocao->promocao->descontopercentual / 100);
                $total += ($precoPromo * $linha->quantidade);
            }else{
                $precoPromo = null;
                $total += ($produto->preco * $linha->quantidade);
            }

            $produtoInfo = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'categoria' => $produto->categoria->nome,
                'filename' => $produto->imagem->filename,
                'preco' => $produto->preco,
                'precoPromo' => $precoPromo,
                'descricao' => $produto->descricao,
            ];

            $linhasFormatadas[] = [
                'id' => $linha->id,
                'quantidade' => $linha->quantidade,
                'produto' => $produtoInfo,
            ];
        }
    }

    $dataCarrinho = [
        'total' => $total,
        'linhacarrinhos' => $linhasFormatadas,
    ];

        return[
            'success' => true,
            //'carrinho' => $carrinho,
            'carrinho' => $dataCarrinho
        ];

    }




    private function verificaTipoEntrega($tipoEntrega, $request, $user_id = null){
        if($tipoEntrega === 'Morada'){
            $moradaId = $request->post('morada_id');

            //Verifica se o moradaid é inválido e retorna false.

            if(!$moradaId || !is_numeric($moradaId)){
                return[
                    'success' => false,
                    'error' => 'Id da morada tem de estar preenchido'
                ];
            }

            //Procura morada
            $morada = Morada::findOne(['id' => $moradaId, 'user_id' => $user_id]);
            if(!$morada){
                return[
                    'success' => false,
                    'error' => 'Id da morada não pertence ao utilizador ou não existe.'
                ];
            }

            $expedicao = new MoradaExpedicao();
            $expedicao->rua = $morada->rua;
            $expedicao->localidade = $morada->localidade;
            $expedicao->codpostal = $morada->codpostal;
            $expedicao->save();
            return [
                'success' => true,
                'moradaexpedicao_id' => $expedicao->id
            ];

        }
        elseif($tipoEntrega === 'Loja')
        {
            $lojaId = $request->post('loja_id');

            //Verifica se o lojaId é invalido e retorna false.
            if(!$lojaId || !is_numeric($lojaId)){
                return [
                    'success' => false,
                    'error' => 'Id da loja tem de estar preenchido'
                ];
            }

            //Procura loja

            $loja = Loja::findOne($lojaId);

            if(!$loja){
                return [
                    'success' =>false,
                    'error' =>'Loja inserida não existe.'
                ];
            }

            $expedicao = new MoradaExpedicao();
            $expedicao->rua = $loja->rua;
            $expedicao->localidade = $loja->localidade;
            $expedicao->codpostal = $loja->codpostal;
            $expedicao->save();
            return [
                'success' => true,
                'loja_id' => $lojaId,
                'moradaexpedicao_id' => $expedicao->id
            ];
        }
        else{
            return [
                'success' => false,
                'error' => 'Algo de estranho aconteceu'

            ];
        }
    }

}