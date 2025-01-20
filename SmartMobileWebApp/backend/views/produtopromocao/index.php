<?php

use common\models\ProdutoPromocao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produto Promocão';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-promocao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Produto Promocão', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datainicio',
            'datafim',
            [
                'attribute' => 'produto_id',
                'value' => function ($model) {
                    return $model->produto->nome;
                },
                'label' => 'Produto',
            ],
            [
                'attribute' => 'promocoes_id',
                'value' => function ($model) {
                    return $model->promocao->nome;
                },
                'label' => 'Promoção',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProdutoPromocao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>



</div>
