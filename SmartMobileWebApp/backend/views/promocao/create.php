<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Promocao $model */

$this->title = 'Criar Promocão';
$this->params['breadcrumbs'][] = ['label' => 'Promocão', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
