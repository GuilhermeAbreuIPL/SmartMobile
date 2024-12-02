<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/flatpickr', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');

/** @var yii\web\View $this */
/** @var common\models\ProdutoPromocao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-promocao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'datainicio')->textInput([
        'class' => 'form-control datetimepicker',
        'value' => $model->datainicio ? Yii::$app->formatter->asDatetime($model->datainicio, 'php:Y-m-d H:i') : ''
    ]) ?>

    <?= $form->field($model, 'datafim')->textInput([
        'class' => 'form-control datetimepicker',
        'value' => $model->datafim ? Yii::$app->formatter->asDatetime($model->datafim, 'php:Y-m-d H:i') : ''
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

<?php
$this->registerJs("$('.select2').select2({ allowClear: true, minimumInputLength: 1, width: '100%' });", View::POS_END);

$this->registerJs("
    $(document).ready(function() {
        if (typeof flatpickr !== 'undefined') {
            $('.datetimepicker').flatpickr({
                enableTime: true,
                dateFormat: 'Y-m-d H:i',
                time_24hr: true,
                allowInput: true
            });
        }
    });
", View::POS_READY);
?>
