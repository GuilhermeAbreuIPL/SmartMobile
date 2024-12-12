<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserForm $model */

$this->title = 'Editar Perfil';
?>
<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/forms.css') ?>">

<h1><?= Html::encode($this->title) ?></h1>

<div class="container-form">

    <div class="form-box"


        <?php $form = ActiveForm::begin(); ?>

        <!-- Campo Nome -->
        <?= $form->field($model, 'nome', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>
        <!-- Campo Username -->
        <?= $form->field($model, 'username', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true, ]) ?>
        <!-- Campo Email (desativado) -->
        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true, ]) ?>
        <!-- Campo NIF -->
        <?= $form->field($model, 'nif', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>
        <!-- Campo Telemóvel -->
        <?= $form->field($model, 'telemovel', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>

        <div class="extra-options">
            Deseja <?= Html::a('voltar', ['user/view'], ['class' => 'link']) ?>?
        </div>

        <!-- Botão para salvar alterações -->
        <div class="form-group">
            <?= Html::submitButton('Guardar Alterações', ['class' => 'btn submit-button', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

