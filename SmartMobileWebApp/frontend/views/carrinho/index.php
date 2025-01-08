<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $carrinho app\models\Carrinho */
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/carrinho_index.css') ?>">

<div class="container">
    <div class="orders">
        <h1 class="title">O meu carrinho</h1>

        <?php foreach ($carrinho->linhacarrinhos as $linha): ?>
            <div class="order-card">
                <div class="order-info">
                    <div class="container_img">
                        <?php if ($linha->produto->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $linha->produto->imagem->filename))): ?>
                            <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $linha->produto->imagem->filename) ?>"
                                 alt="<?= Html::encode($linha->produto->nome) ?>" class="order-image" />
                        <?php else: ?>
                            <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                                 alt="Imagem padrão" class="order-image" />
                        <?php endif; ?>
                    </div>
                    <div class="infos">
                        <div>
                            <p class="order-label">Nome</p>
                            <p class="order-value"><?= Html::encode($linha->produto->nome) ?></p>
                        </div>
                        <div>
                            <p class="order-label">Preço Unitário</p>
                            <p class="order-value"><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></p>
                        </div>
                        <div>
                            <p class="order-label">Quantidade</p>
                            <p class="order-value"><?= Html::encode($linha->quantidade) ?></p>
                            <div class="btn-quantity-container">
                                <a href="<?= Url::to(['carrinho/add', 'id' => $linha->produto_id]) ?>" class="btn-quantity" id="addquantity-<?=$linha->produto->id ?>">+</a>
                                <a href="<?= Url::to(['carrinho/remove', 'id' => $linha->produto_id]) ?>" class="btn-quantity" id="removequantity-<?=$linha->produto->id ?>">-</a>
                            </div>
                        </div>
                        <div class="total-info">
                            <p class="order-label">Total</p>
                            <p class="order-value"><?= Yii::$app->formatter->asCurrency($linha->quantidade * $linha->precounitario) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="checkout-btn-container" id="checkout-btn">
            <?php if(empty($carrinho->linhacarrinhos)): ?>
                <p class="text-center text-white">O carrinho está vazio.</p>
            <?php else:; ?>
            <a href="<?= Url::to(['fatura/checkout']) ?>" class="btn-checkout">Finalizar Compra</a>
            <?php endif; ?>
        </div>
    </div>
</div>
