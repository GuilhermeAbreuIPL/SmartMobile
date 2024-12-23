<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\fatura $model */

$this->title = 'Create Fatura';
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="fatura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="fatura-form">

        <?php $form = ActiveForm::begin(); ?>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Foto</th>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($carrinho->linhacarrinhos as $linha): ?>
                <tr>
                    <td>
                        <?php if ($linha->produto->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $linha->produto->imagem->filename))): ?>
                            <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $linha->produto->imagem->filename) ?>"
                                 alt="<?= Html::encode($linha->produto->nome) ?>"
                                 width="35" height="35" class="product img-fluid">
                        <?php else: ?>
                            <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                                 alt="Imagem padrão"
                                 width="35" height="35" class="product img-fluid">
                        <?php endif; ?>
                    </td>
                    <td><?= Html::encode($linha->produto->nome) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></td>
                    <td><?= Html::encode($linha->quantidade) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($linha->quantidade * $linha->precounitario) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" class="text-end"><strong>Total do Carrinho:</strong></td>
                <td><?= Yii::$app->formatter->asCurrency($model->total) ?></td>
            </tr>
            </tfoot>
        </table>

        <div class="row">
            <!-- Opção: Receber numa morada -->
            <div class="col-md-6">
                <label class="radio-card">
                    <input type="radio" name="tipoentrega" value="morada" checked onchange="toggleDeliveryOption()">
                    <div class="card-content">
                        <i class="fa fa-truck"></i>
                        <span>Desejo receber a encomenda numa morada</span>
                    </div>
                </label>
            </div>

            <!-- Opção: Levantar em loja -->
            <div class="col-md-6">
                <label class="radio-card">
                    <input type="radio" name="tipoentrega" value="loja" onchange="toggleDeliveryOption()">
                    <div class="card-content">
                        <i class="fa fa-store"></i>
                        <span>Desejo levantar a encomenda em loja</span>
                    </div>
                </label>
            </div>
        </div>

        <table class="morada-table">
            <thead>
            <tr>
                <th>Selecionar</th>
                <th>Rua</th>
                <th>Localidade</th>
                <th>Código Postal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($moradas as $morada): ?>
                <!-- Linha da morada existente -->
                <tr data-id="<?= $morada->id ?>">
                    <td>
                        <input type="radio" name="morada" value="<?= $morada->id ?>" />
                    </td>
                    <td><?= Html::encode($morada->rua) ?></td>
                    <td><?= Html::encode($morada->localidade) ?></td>
                    <td><?= Html::encode($morada->codpostal) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <table class="loja-table">
            <thead>
            <tr>
                <th>Selecionar</th>
                <th>Nome</th>
                <th>Morada</th>
                <th>Localidade</th>
                <th>Código Postal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lojas as $loja): ?>
                <!-- Linha da loja existente -->
                <tr data-id="<?= $loja->id ?>">
                    <td>
                        <input type="radio" name="loja" value="<?= $loja->id ?>" />
                    </td>
                    <td><?= Html::encode($loja->nome) ?></td>
                    <td><?= Html::encode($loja->rua) ?></td>
                    <td><?= Html::encode($loja->localidade) ?></td>
                    <td><?= Html::encode($loja->codpostal) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>



        <?= $form->field($model, 'metodopagamento_id')->radioList(
            $metodopagamento,
            [
                'itemOptions' => ['class' => 'radio-inline'],
            ]
        ) ?>



        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
