<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\fatura $model */

$this->title = 'Finalizar compra';
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/finalizar_compra.css') ?>">

<div class="checkout-view">

    <h1 class="Titulo"><?= Html::encode($this->title) ?></h1>


        <?php $form = ActiveForm::begin(); ?>

        <div class="opcao_entrega">
            <div class="escolha">
                <label class="card-escolha">
                    <input type="radio" name="tipoentrega" value="morada" id="morada-btn" checked />
                    <div class="card-escolha-content">
                        <i class="fa fa-truck"></i>
                        <span>Desejo receber a encomenda numa morada</span>
                    </div>
                </label>
            </div>

            <div class="escolha">
                <label class="card-escolha">
                    <input type="radio" name="tipoentrega" value="loja" id="loja-btn" />
                    <div class="card-escolha-content">
                        <i class="fa fa-store"></i>
                        <span>Desejo levantar a encomenda em loja</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Container Dinâmico -->
        <div class="dynamic-list">
            <!-- Lista de Moradas -->
            <div class="morada-list" id="morada-list">
                <?php foreach ($moradas as $morada): ?>
                    <!-- Cartão de morada existente -->
                    <div class="morada-card" data-id="<?= $morada->id ?>">
                        <input type="radio" name="morada" id="btn-morada-user-<?= $morada->id ?>" value="<?= $morada->id ?>" />
                        <p><strong>Rua:</strong> <?= Html::encode($morada->rua) ?></p>
                        <p><strong>Localidade:</strong> <?= Html::encode($morada->localidade) ?></p>
                        <p><strong>Código Postal:</strong> <?= Html::encode($morada->codpostal) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Lista de Lojas -->
            <div class="loja-list" id="loja-list" style="display: none;">
                <?php foreach ($lojas as $loja): ?>
                    <label class="loja-card" data-id="<?= $loja->id ?>">
                        <input type="radio" name="loja" id="btn-loja-user-<?= $loja->id ?>" value="<?= $loja->id ?>" />
                        <p><strong>Nome:</strong> <?= Html::encode($loja->nome) ?></p>
                        <p><strong>Rua:</strong> <?= Html::encode($loja->rua) ?></p>
                        <p><strong>Localidade:</strong> <?= Html::encode($loja->localidade) ?></p>
                        <p><strong>Código Postal:</strong> <?= Html::encode($loja->codpostal) ?></p>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="opcao_pagamento">
            <?php foreach ($metodopagamento as $id => $nome): ?>
                <div class="escolha">
                    <label class="card-pagamento">
                        <input type="radio" name="metodopagamento_id" id="btn-<?= Html::encode($nome) ?>" value="<?= $id ?>" />
                        <div class="card-pagamento-content">
                            <i class="fa fa-credit-card"></i>
                            <span><?= Html::encode($nome) ?></span>
                        </div>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

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

            <div>
                <?= Html::submitButton('Finalizar Compra', ['class' => 'btn-finalizar']) ?>
            </div>
        <?php ActiveForm::end(); ?>
</div>

<script src="<?= Yii::getAlias('@web/js/checkout.js') ?>"></script>