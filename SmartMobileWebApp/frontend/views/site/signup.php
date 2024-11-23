<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength'=> 255 , 'autofocus' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                <?= $form->field($model, 'password')->passwordInput()?>

                <?= $form->field($model, 'nome')->textInput(['maxlength' => 45]) ?>

                <?= $form->field($model, 'nif')->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

                <?= $form->field($model, 'telemovel')->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

                <?= $form->field($model, 'role')->hiddenInput(['value' => 'Cliente'])->label(false) ?>


            <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
