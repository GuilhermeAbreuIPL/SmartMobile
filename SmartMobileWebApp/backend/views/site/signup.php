<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */

$this->title = 'Criar User';

// Definir as roles permitidas com base na role do usuário logado
$roles = [];
if (Yii::$app->user->can('creategestor')) {
    $roles = [
        'gestor' => 'Gestor',
        'funcionario' => 'Funcionario',
        'cliente' => 'Cliente'
    ];
} elseif (Yii::$app->user->can('createfuncionario')) {
    $roles = [
        'funcionario' => 'Funcionario',
        'cliente' => 'Cliente'
    ];
} elseif (Yii::$app->user->can('createcliente')){
    $roles = [
        'cliente' => 'Cliente'
    ];
}
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="user-signup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nif')->textInput(['maxlength' => 9]) ?>

    <?= $form->field($model, 'telemovel')->textInput(['maxlength' => 9]) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(
        $roles,
        ['prompt' => 'Selecione um papel', 'required' => true]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Criar Usuário', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>