<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Morada $model */

?>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/forms.css') ?>">


        <h1><?= $model->isNewRecord ? 'Criar Morada' : 'Editar Morada' ?></h1>

    <div class="container-form">

        <div class="form-box">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'rua', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'localidade', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'codpostal', ['options' => ['class' => 'form-group input-field']])->textInput(['maxlength' => true]) ?>

            <div class="extra-options">
                Deseja <?= Html::a('voltar', ['user/view'], ['class' => 'link']) ?>?
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn submit-button', 'name' => 'signup-button']) ?>
                <?php if (!$model->isNewRecord): ?>
                    <?= Html::a('Apagar', ['delete-morada', 'moradaId' => $model->id], [
                        'class' => 'btn danger-button',
                        'data-confirm' => 'Tem certeza que deseja apagar esta morada?',
                        'data-method' => 'post',
                    ]) ?>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
