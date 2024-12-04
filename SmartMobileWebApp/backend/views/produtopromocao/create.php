<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProdutoPromocao $model */

$this->title = 'Criar Produto Promocão';
$this->params['breadcrumbs'][] = ['label' => 'Produto Promocão', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-promocao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'promocao' => $promocao,
        'produtos' => $produtos,
    ]) ?>

</div>
