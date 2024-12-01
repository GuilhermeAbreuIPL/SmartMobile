<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/signup.css?v=') ?>">

<div class="container-signup">

    <div class="signup-box">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength'=> 255 , 'autofocus' => true]) ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'password', ['options' => ['class' => 'form-group input-field']])->passwordInput()?>

        <?= $form->field($model, 'nome', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => 45]) ?>

        <?= $form->field($model, 'nif', ['options' => ['class' => 'form-group input-field']])->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

        <?= $form->field($model, 'telemovel', ['options' => ['class' => 'form-group input-field']])->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

        <?= $form->field($model, 'role')->hiddenInput(['value' => 'Cliente'])->label(false) ?>

        <div class="extra-options">
            Deseja <?= Html::a('voltar', ['site/index'], ['class' => 'link']) ?>?
        </div>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn submit-button', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
