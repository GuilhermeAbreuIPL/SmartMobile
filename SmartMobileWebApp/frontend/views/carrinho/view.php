<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $carrinho app\models\Carrinho */
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/card_carrinho.css') ?>">

<div class="container_carrinho">
    <?php foreach ($carrinho->linhacarrinhos as $linha): ?>
        <div class="card_carrinho">
            <div class="card_carrinho_img">
                <?php if ($linha->produto->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $linha->produto->imagem->filename))): ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $linha->produto->imagem->filename) ?>"
                         alt="<?= Html::encode($linha->produto->nome) ?>" />
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                         alt="Imagem padrão" />
                <?php endif; ?>
            </div>
            <div class="card_carrinho_content">
                <h5><?= Html::encode($linha->produto->nome) ?></h5>
                <p><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></p>
                <div class="card_carrinho_quantity">
                    <div class="card_carrinho_quantity">
                        <?= Html::a('+', ['add', 'id' => $linha->produto_id], ['class' => 'btn_carrinho']) ?>
                        <input type="text" id="quantidade_<?= $linha->produto_id ?>" value="<?= Html::encode($linha->quantidade) ?>" readonly />
                        <?= Html::a('-', ['remove', 'id' => $linha->produto_id], ['class' => 'btn_carrinho']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-3">
    <?= Html::button('Carrinho', ['class' => 'btn btn-primary carrinho', 'onclick' => 'location.href="' . Yii::$app->urlManager->createUrl(['carrinho/index']) . '"']) ?>

</div>