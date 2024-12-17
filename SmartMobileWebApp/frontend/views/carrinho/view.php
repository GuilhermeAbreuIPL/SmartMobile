<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $carrinho app\models\Carrinho */
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Foto</th>
        <th>Produto</th>
        <th>Preço Unitário</th>
        <th>Quantidade</th>
        <th>Total</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($carrinho->linhacarrinhos as $linha): ?>
        <tr>
            <td>
                <?php if ($linha->produto->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $linha->produto->imagem->filename))): ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $linha->produto->imagem->filename) ?>"
                         alt="<?= Html::encode($linha->produto->nome) ?>"
                         width="10" height="10" class="product img-fluid">
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                         alt="Imagem padrão"
                         width="10" height="10" class="product img-fluid">
                <?php endif; ?>
            </td>
            <td><?= Html::encode($linha->produto->nome) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></td>
            <td><?= Html::encode($linha->quantidade) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->quantidade * $linha->precounitario) ?></td>
            <td>
                <?= Html::a('Adicionar', ['add', 'id' => $linha->produto_id], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('Remover', ['remove', 'id' => $linha->produto_id], ['class' => 'btn btn-danger btn-sm']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="mt-3">
    <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>
