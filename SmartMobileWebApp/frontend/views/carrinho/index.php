<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var $carrinho app\models\Carrinho */
?>

<h1>Meu Carrinho</h1>

<?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $carrinho->linhacarrinhos,
        'pagination' => false,
    ]),
    'columns' => [
        [
            'label' => 'Produto',
            'value' => function ($model) {
                return $model->produto->nome;
            },
        ],
        [
            'label' => 'Preço Unitário',
            'value' => function ($model) {
                return Yii::$app->formatter->asCurrency($model->precounitario);
            },
        ],
        'quantidade',
        [
            'label' => 'Total',
            'value' => function ($model) {
                return Yii::$app->formatter->asCurrency($model->quantidade * $model->precounitario);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{add} {remove}',
            'buttons' => [
                'add' => function ($url, $model) {
                    return Html::a('Adicionar', Url::to(['carrinho/add', 'id' => $model->produto_id]), [
                        'class' => 'btn btn-success btn-sm',
                    ]);
                },
                'remove' => function ($url, $model) {
                    return Html::a('Remover', Url::to(['carrinho/remove', 'id' => $model->produto_id]), [
                        'class' => 'btn btn-danger btn-sm',
                    ]);
                },
            ],
        ],
    ],
]); ?>

<div class="mt-3">
    <?= Html::a('Finalizar Compra', ['checkout/index'], ['class' => 'btn btn-primary']) ?>
</div>
