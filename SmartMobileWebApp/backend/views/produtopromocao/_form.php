<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css');

/** @var yii\web\View $this */
/** @var common\models\ProdutoPromocao $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="produto-promocao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'datainicio')->textInput([
        'class' => 'form-control datepicker',
        'value' => $model->datainicio ? Yii::$app->formatter->asDate($model->datainicio, 'php:Y-m-d') : ''
    ]) ?>

    <?= $form->field($model, 'datafim')->textInput([
        'class' => 'form-control datepicker',
        'value' => $model->datafim ? Yii::$app->formatter->asDate($model->datafim, 'php:Y-m-d') : ''
    ]) ?>

    <?= $form->field($model, 'produto_id')->dropDownList(
        ArrayHelper::map($produtos, 'id', 'nome'),
        [
            'class' => 'form-control select2',
            'prompt' => 'Selecione um produto',
            'required' => true,
        ]
    )->label('Produto') ?>

    <?= $form->field($model, 'promocoes_id')->dropDownList(
        ArrayHelper::map($promocao, 'id', function($lista) {
            return $lista['nome'] . ' ( ' . $lista['descontopercentual'] . ' % )';
        }),
        ['prompt' => 'Selecione uma promoção', 'required' => true]
    )->label('Promoções') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src=" <?= Yii::getAlias('@web/js/produtopromocao.js') ?>"></script>
