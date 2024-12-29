<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ $model */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-group user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength'=> 255 , 'autofocus' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput()?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'nif')->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

    <?= $form->field($model, 'telemovel')->textInput(['minlength' => 9, 'maxlength' => 9]) ?>

    <?= $form->field($model, 'role')->label('Role')->dropDownList(
        $roles,
        ['prompt' => 'Seleciona a role do user...', 'required' => true]
    );
    ?>

    <?= Html::submitButton('Create User', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

