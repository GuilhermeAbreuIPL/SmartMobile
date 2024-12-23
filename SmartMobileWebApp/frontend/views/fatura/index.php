<?php

use common\models\fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // Data da fatura, com formatação mais amigável
            [
                'attribute' => 'datafatura',
                'format' => ['date', 'php:d/m/Y H:i:s'],
            ],

            // Total da fatura formatado como moeda
            [
                'attribute' => 'total',
                'format' => ['currency'],
            ],

            // Status do pedido
            'statusorder',

            // Método de pagamento - se desejar mostrar o nome em vez do ID, você pode fazer um relacionamento
            [
                'attribute' => 'metodopagamento_id',
                'value' => function ($model) {
                    return $model->metodopagamento ? $model->metodopagamento->nome : 'Não especificado';
                },
            ],

            // Tipo de entrega
            [
                'attribute' => 'tipoentrega',
                'value' => function ($model) {
                    return ucfirst($model->tipoentrega); // Exibe 'Morada' ou 'Loja' com a primeira letra maiúscula
                },
            ],

            // Ação: Visualizar fatura
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view}', // Exibe apenas o botão de visualização
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver Detalhes', $url, [
                            'class' => 'btn btn-warning', // Estilo do botão amarelo
                            'style' => 'background-color: #f0ad4e; color: white;', // Estilo adicional para garantir a cor amarela
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
