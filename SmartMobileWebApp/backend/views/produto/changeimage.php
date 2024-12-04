<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Alterar Imagem';
$this->params['breadcrumbs'][] = ['label' => 'Imagens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="table-responsive mx-auto" ">
    <table class="table table-bordered">
        <tr>
            <td class="text-center" style="width: 50%;"><h3>Imagem Atual:</h3>
                <?php if ($model->filename): ?>
                    <img src="<?= Yii::getAlias('@web') ?>/uploads/<?= $model->filename ?>" alt="Imagem Atual" width="300">
                <?php else: ?>
                    <p>Nenhuma imagem associada.</p>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <h3>Nova Imagem:</h3>
                <?= $form->field($model, 'filename')->fileInput() ?>
            </td>
        </tr>
    </table>
</div>

<div class="form-group">
    <?= Html::submitButton('Alterar Imagem', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
