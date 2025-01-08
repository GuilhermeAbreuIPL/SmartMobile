<?php

use common\models\LinhaFatura;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\fatura $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Detalhes da Fatura';
?>
<div class="fatura-view">

    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/fatura_details.css') ?>">

    <div class="fatura-index">
        <h1><?= Html::encode($this->title) ?></h1>

        <table class="table table-bordered detail-view">
            <tbody>
            <tr>
                <th>Data da Fatura</th>
                <td><?= Yii::$app->formatter->asDatetime($model->datafatura, 'php:d/m/Y H:i:s') ?></td>
            </tr>
            <tr>
                <th>Valor Total</th>
                <td><?= Yii::$app->formatter->asCurrency($model->total) ?></td>
            </tr>
            <tr>
                <th>Status do Pedido</th>
                <td><?= Html::encode($model->statusorder) ?></td>
            </tr>
            <tr>
                <th>Método de Pagamento</th>
                <td><?= $model->metodopagamento ? Html::encode($model->metodopagamento->nome) : 'Não especificado' ?></td>
            </tr>
            <tr>
                <th>Tipo de Entrega</th>
                <td><?= ucfirst(Html::encode($model->tipoentrega)) ?></td>
            </tr>
            </tbody>
        </table>

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
                    'label' => 'Total',
                    'format' => ['currency'],
                    'value' => function ($model) {
                        return $model ? $model->precounitario * $model->quantidade : 'Produto não encontrado';
                    },
                ],
            ],
        ]) ?>
    </div>

    <p>
        <?= Html::a('Voltar para as Faturas', ['index'], ['class' => 'btn btn-warning', 'id' => 'btn-voltar']) ?>
    </p>

</div>
