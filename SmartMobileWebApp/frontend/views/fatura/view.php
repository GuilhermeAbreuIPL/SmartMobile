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
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/btn_download.css') ?>">

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
        <?= Html::a(
            '<div>
        <div class="icon">
            <div>
                <svg class="arrow" viewBox="0 0 20 18" fill="currentColor">
                    <polygon points="8 0 12 0 12 9 15 9 10 14 5 9 8 9"></polygon>
                </svg>
                <svg class="shape" viewBox="0 0 20 18" fill="currentColor">
                    <path d="M4.82668561,0 L15.1733144,0 C16.0590479,0 16.8392841,0.582583769 17.0909106,1.43182334 L19.7391982,10.369794 C19.9108349,10.9490677 19.9490212,11.5596963 19.8508905,12.1558403 L19.1646343,16.3248465 C19.0055906,17.2910371 18.1703851,18 17.191192,18 L2.80880804,18 C1.82961488,18 0.994409401,17.2910371 0.835365676,16.3248465 L0.149109507,12.1558403 C0.0509788145,11.5596963 0.0891651114,10.9490677 0.260801785,10.369794 L2.90908938,1.43182334 C3.16071592,0.582583769 3.94095214,0 4.82668561,0 Z"></path>
                </svg>
            </div>
            <span></span>
        </div>
        <div class="label">
            <div class="show default">Baixar Fatura (PDF)</div>
            <div class="state">
                <div class="counter">
                    <ul><li></li><li>1</li></ul>
                    <ul>
                        <?php foreach (range(0, 9) as $val) : ?>
                            <li><?= $val ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <ul>
                        <?php foreach (range(0, 29) as $val) : ?>
                            <li><?= $val % 10 ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <span>%</span>
                </div>
                <span>Done</span>
            </div>
        </div>
        <div class="progress"></div>
    </div>',
            ['fatura/pdf', 'id' => $model->id],
            ['class' => 'dl-button', 'style' => 'border-radius: 8px; font-weight: bold; padding: 10px 20px;']
        ) ?>

    </div>




        <?= Html::a('Voltar para as Faturas', ['index'], [
            'class' => 'btn btn-warning btn-lg',
            'id' => 'btn-voltar',
            'style' => 'border-radius: 8px; font-weight: bold; padding: 10px 20px;'
        ]) ?>


</div>

