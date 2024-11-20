<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \backend\models\UserForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength'=> 255 , 'autofocus' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'password')->passwordInput()?>

            <?= $form->field($model, 'nome')->textInput(['maxlength' => 45]) ?>

            <?= $form->field($model, 'nif')->textInput(['maxlength' => 9]) ?>

            <?= $form->field($model, 'telemovel')->textInput(['maxlength' => 9]) ?>

            <?= $form->field($model, 'role')->label('Role')->dropDownList(
                $roles,
                ['prompt' => 'Seleciona a role do user...', 'required' => true]
            );
            ?>

            <div class="form-group">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
