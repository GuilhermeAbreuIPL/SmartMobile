<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ActiveForm; ?>
<?php use yii\helpers\ArrayHelper; ?>

<?php
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/flatpickr', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
?>

<div class="compra-loja-create">

    <h1>Criar Compra para a Loja</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loja_id')->hiddenInput(['value' => $lojaId])->label(false) ?>

    <!-- Preço do fornecedor - somente números -->
    <?= $form->field($model, 'preçofornecedor')->textInput(['type' => 'number', 'min' => 0]) ?>

    <!-- Quantidade - com controles de incremento/diminuição -->
    <?= $form->field($model, 'quantidade')->textInput(['type' => 'number', 'min' => 1]) ?>

    <!-- Data de compra - utilizando o flatpickr -->
    <?= $form->field($model, 'datacompra')->textInput(['class' => 'datetimepicker', 'value' => date('y-m-d')]) ?>

    <!-- Fornecedor - dropdownlist -->
    <?= $form->field($model, 'fornecedor_id')->dropDownList(
        ArrayHelper::map($fornecedores, 'id', 'empresa'),
        ['prompt' => 'Selecione um fornecedor', 'class' => 'form-control']
    ) ?>

    <!-- Produto - dropdownlist -->
    <?= $form->field($model, 'produto_id')->dropDownList(
        ArrayHelper::map($produtos, 'id', 'nome'),
        [
            'class' => 'form-control select2',
            'prompt' => 'Selecione um produto',
            'required' => true,
        ]
    )->label('Produto') ?>

    <div class="form-group">
        <?= Html::submitButton('Criar Compra', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src=" <?= Yii::getAlias('@web/js/compraloja.js') ?> " ></script>
