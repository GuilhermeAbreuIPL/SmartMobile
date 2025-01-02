<?php

use common\models\fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

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
            ['class' => 'yii\grid\SerialColumn'],
            // ID da fatura com #
            [
                'attribute' => 'id',
                'label' => 'Fatura ID',
            ],

            // Data da fatura formatada
            [
                'attribute' => 'datafatura',
                'format' => ['date', 'php:d/m/Y H:i:s'],
                'label' => 'Data da Fatura',
            ],

            // Total da fatura
            [
                'attribute' => 'total',
                'format' => ['currency'],
                'label' => 'Total',
            ],

            // Status do pedido com dropdown
            [
                'attribute' => 'statusorder',
                'format' => 'raw',
                'label' => 'Status',
                'value' => function ($model) {
                    // URL para a ação que processa a alteração do status
                    $url = Url::to(['fatura/change-status?id=' . $model->id]);

                    // Gera o formulário com dropdown e botão
                    return Html::beginForm($url, 'post', ['class' => 'form-inline'])
                        . Html::hiddenInput('id', $model->id)
                        . Html::dropDownList('status', $model->statusorder, [
                            'Confirmação Pendente' => 'Confirmação Pendente',
                            'Processamento' => 'Processamento',
                            'Concluído' => 'Concluído',
                            'Cancelado' => 'Cancelado',
                        ], ['class' => 'form-control'])
                        . ' '
                        . Html::submitButton('Alterar', ['class' => 'btn btn-success btn-sm'])
                        . Html::endForm();
                },
            ],


            // Método de pagamento
            [
                'attribute' => 'metodopagamento_id',
                'value' => function ($model) {
                    return $model->metodopagamento ? $model->metodopagamento->nome : 'Não especificado';
                },
                'label' => 'Método de Pagamento',
            ],

            // Tipo de entrega
            [
                'attribute' => 'tipoentrega',
                'value' => function ($model) {
                    return ucfirst($model->tipoentrega);
                },
                'label' => 'Tipo de Entrega',
            ],

            // Botão de ação para visualizar detalhes
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver Detalhes', $url, [
                            'class' => 'btn btn-warning',
                            'style' => 'background-color: #f0ad4e; color: white;',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
