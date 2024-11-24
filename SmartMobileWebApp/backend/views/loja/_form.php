<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Loja $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="loja-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'contacto')->textInput(['maxlength' => 9]) ?>

    <?= $form->field($model, 'localizacao')->textInput(['maxlength' => 45]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
