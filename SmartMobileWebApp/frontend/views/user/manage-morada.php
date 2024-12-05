<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Morada $model */

?>

    <div class="morada-form">
        <h1><?= $model->isNewRecord ? 'Criar Morada' : 'Editar Morada' ?></h1>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'rua')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'localidade')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'codpostal')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-primary']) ?>
            <?php if (!$model->isNewRecord): ?>
                <?= Html::a('Apagar', ['delete-morada', 'moradaId' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data-confirm' => 'Tem certeza que deseja apagar esta morada?',
                    'data-method' => 'post',
                ]) ?>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
