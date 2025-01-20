<?php

use common\models\LinhaFatura;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\fatura $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Detalhes da Fatura';
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Voltar para as Faturas', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <!-- Detalhes da fatura -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // Data da fatura com formato amigável
            [
                'attribute' => 'datafatura',
                'label' => 'Data da Fatura',
                'format' => ['date', 'php:d/m/Y H:i:s'],
            ],

            // Total da fatura formatado como moeda
            [
                'attribute' => 'total',
                'label' => 'Valor Total',
                'format' => ['currency'],
            ],

            // Status do pedido
            [
                'attribute' => 'statusorder',
                'label' => 'Status do Pedido',
            ],

            // Método de pagamento
            [
                'attribute' => 'metodopagamento_id',
                'label' => 'Método de Pagamento',
                'value' => $model->metodopagamento ? $model->metodopagamento->nome : 'Não especificado',
            ],

            // Tipo de entrega (morada ou loja)
            [
                'attribute' => 'tipoentrega',
                'label' => 'Tipo de Entrega',
                'value' => ucfirst($model->tipoentrega),
            ],
        ],
    ]) ?>

    <h3>Produtos da Fatura</h3>

    <!-- Tabela com as linhas da fatura -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // Imagem do produto
            [
                'attribute' => 'produto_id',
                'label' => 'Imagem do Produto',
                'value' => function ($model) {
                    $imagePath = $model->produto->imagem ? Yii::getAlias('@backendUrl/uploads/' . $model->produto->imagem->filename) : Yii::getAlias('@backendUrl/uploads/default.jpg');
                    return Html::img($imagePath, [
                        'alt' => $model->produto->nome,
                        'class' => 'product img-fluid',
                        'style' => 'max-width: 100px; max-height: 100px; object-fit: contain;'
                    ]);
                },
                'format' => 'raw',
            ],

            // Nome do produto
            [
                'attribute' => 'produto_id',
                'label' => 'Nome do Produto',
                'value' => function ($model) {
                    return $model->produto ? $model->produto->nome : 'Produto não encontrado';
                },
            ],

            // Quantidade do produto
            [
                'attribute' => 'quantidade',
                'label' => 'Quantidade',
            ],

            // Preço pago pelo produto
            [
                'attribute' => 'preco_pago',
                'label' => 'Preço Pago',
                'format' => ['currency'],
                'value' => function ($model) {
                    return $model ? $model->precounitario * $model->quantidade : 'Produto não encontrado';
                },
            ],
        ],
    ]) ?>

</div>
