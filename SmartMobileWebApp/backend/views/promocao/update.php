<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Promocao $model */

$this->title = 'Editar Promocão: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promocão', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promocao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
