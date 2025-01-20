<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProdutoPromocao $model */

$this->title = 'Update Produto Promocão: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Produto Promocão', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="produto-promocao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'promocao' => $promocao,
        'produtos' => $produtos,
    ]) ?>

</div>
