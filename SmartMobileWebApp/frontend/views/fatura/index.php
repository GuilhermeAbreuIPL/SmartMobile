<?php

use common\models\fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
?>

<div class="fatura-index">

    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/faturas.css') ?>">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'datafatura',
                'format' => ['date', 'php:d/m/Y H:i:s'],
                'label' => 'Data',
            ],

            [
                'attribute' => 'total',
                'format' => ['currency'],
                'label' => 'Total',
            ],

            [
                'attribute' => 'statusorder',
                'label' => 'Estado da Encomenda',
            ],

            [
                'attribute' => 'metodopagamento_id',
                'label' => 'Metodo Pagamento',
                'value' => function ($model) {
                    return $model->metodopagamento ? $model->metodopagamento->nome : 'Não especificado';
                },
            ],

            [
                'attribute' => 'tipoentrega',
                'label' => 'Entrega',
                'value' => function ($model) {
                    return ucfirst($model->tipoentrega);
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver Detalhes', $url, [
                            'class' => 'btn btn-warning',
                            'id' => 'view-details-' . $model->id,
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>