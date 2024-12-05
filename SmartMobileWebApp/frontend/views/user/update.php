<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserForm $model */

$this->title = 'Editar Perfil';
?>
<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campo Nome -->
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <!-- Campo Username -->
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, ]) ?>
    <!-- Campo Email (desativado) -->
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, ]) ?>
    <!-- Campo NIF -->
    <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>
    <!-- Campo Telemóvel -->
    <?= $form->field($model, 'telemovel')->textInput(['maxlength' => true]) ?>

    <!-- Botão para salvar alterações -->
    <div class="form-group">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
