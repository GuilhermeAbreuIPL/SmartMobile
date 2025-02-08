<?php
use yii\helpers\Html;
?>

<h1>Fatura #<?= Html::encode($model->id) ?></h1>
<p><strong>Smartmobile.com</strong></p>
<p><strong>Data:</strong> <?= Yii::$app->formatter->asDate($model->datafatura, 'php:d/m/Y H:i:s') ?></p>
<p><strong>Total:</strong> <?= Yii::$app->formatter->asCurrency($model->total) ?></p>
<p><strong>Status:</strong> <?= Html::encode($model->statusorder) ?></p>
<p><strong>Tipo de Entrega:</strong> <?= Html::encode($model->tipoentrega) ?></p>
<p><strong>Total:</strong> <?= Html::encode($model->total) ?></p>

<h2>Produtos</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($linhasFatura as $linha): ?>
        <tr>
            <td><?= Html::encode($linha->produto->nome) ?></td>
            <td><?= Html::encode($linha->quantidade) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->quantidade * $linha->precounitario) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

