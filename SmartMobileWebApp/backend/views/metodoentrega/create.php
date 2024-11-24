<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\MetodoEntrega $model */

$this->title = 'Create Metodo Entrega';
$this->params['breadcrumbs'][] = ['label' => 'Metodo Entregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodo-entrega-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
