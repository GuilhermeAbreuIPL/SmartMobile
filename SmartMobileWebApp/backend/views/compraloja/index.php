<?php use yii\helpers\Html; ?>

<div class="compra-loja-index">

    <h1>Compra Lojas</h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($lojaId === null): ?>
        <div class="alert alert-warning">
            Por favor, selecione uma loja para visualizar as compras.
        </div>

        <?= Html::beginForm(['compraloja/index'], 'get') ?>
        <?= Html::dropDownList('lojaId', $lojaId,
            yii\helpers\ArrayHelper::map($lojas, 'id', 'nome'),
            ['prompt' => 'Selecione uma loja', 'class' => 'form-control', 'required' => true]) ?>
        <?= Html::submitButton('Ver Compras', ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px;']) ?>
        <?= Html::endForm() ?>

    <?php else: ?>
        <p>
            <?= Html::a('Criar Compra', ['create', 'lojaId' => $lojaId], ['class' => 'btn btn-success']) ?>
        </p>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'preçofornecedor',
                'quantidade',
                'datacompra',
                [
                    'label' => 'Produto',
                    'value' => function ($model) {
                        return $model->produto ? $model->produto->nome : 'Desconhecido';
                    }
                ],
                [
                    'label' => 'Fornecedor',
                    'value' => function ($model) {
                        return $model->fornecedor ? $model->fornecedor->empresa : 'Desconhecido';
                    }
                ],
            ],
        ]) ?>
    <?php endif; ?>

</div>
