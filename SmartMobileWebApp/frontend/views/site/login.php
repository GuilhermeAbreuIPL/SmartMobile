<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/login.css?v=') ?>">


<div class="container-login">
    <div class="login-box">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username', ['options' => ['class' => 'form-group input-field']])->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password', ['options' => ['class' => 'form-group input-field']])->passwordInput() ?>

        <div class="extra-options">
            Esqueceu-se da sau senha, pode a  <?= Html::a('redefinir', ['site/request-password-reset'], ['class' => 'link']) ?>.
            <br>
            Deseja <?= Html::a('voltar', ['site/index'], ['class' => 'link']) ?>?
        </div>

        <div class="form-group button-wrapper">
            <?= Html::submitButton('Login', ['class' => 'btn submit-button', 'name' => 'login-button', 'id'=>'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>



