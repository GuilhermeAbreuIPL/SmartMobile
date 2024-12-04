<?php use yii\helpers\Html; ?>
<?php use yii\widgets\ActiveForm; ?>

<?php if ($lojaId === null): ?>
    <div class="alert alert-warning">
        Por favor, selecione uma loja para visualizar os produtos.
    </div>

    <?= Html::beginForm(['produtoloja/index'], 'get') ?>
    <?= Html::dropDownList('lojaId', $lojaId,
        yii\helpers\ArrayHelper::map($lojas, 'id', 'nome'),
        ['prompt' => 'Selecione uma loja', 'class' => 'form-control']) ?>
    <?= Html::submitButton('Ver Produtos', ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px;']) ?>
    <?= Html::endForm() ?>

<?php else: ?>
    <h2>Produtos da Loja: <?= Html::encode($produtolojas->nome) ?></h2>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <!-- Barra de Pesquisa com Select2 -->
    <?= Html::beginForm(['produtoloja/search', 'lojaId' => $lojaId], 'get') ?>
    <?= Html::textInput('search', $search, [
        'class' => 'form-control select2',
        'placeholder' => 'Pesquise por produto...',
    ]) ?>
    <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-info', 'style' => 'margin-top: 10px; margin-bottom: 10px']) ?>
    <?= Html::endForm() ?>

    <?php if (empty($produtos)): ?>
        <p>Nenhum produto encontrado.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Stock</th>
                <th>Adicionar Stock</th>
                <th>Remover Stock</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= Html::encode($produto->nome) ?></td>
                    <td><?= Html::encode($produto->descricao) ?></td>
                    <td><?= Html::encode($produto->preco) ?>€</td>
                    <td>
                        <?php
                        $produtoloja = $produto->produtolojas[0] ?? null;
                        echo $produtoloja ? Html::encode($produtoloja->quantidade) : '0';
                        ?>
                    </td>
                    <td>
                        <?= Html::beginForm(['produtoloja/add-stock', 'produtoId' => $produto->id, 'lojaId' => $lojaId], 'post') ?>
                        <?= Html::input('number', 'quantidade', 1, ['min' => 1, 'class' => 'form-control', 'style' => 'width: 80px; display: inline-block;']) ?>
                        <?= Html::submitButton('Adicionar Stock', ['class' => 'btn btn-success']) ?>
                        <?= Html::endForm() ?>
                    </td>
                    <td>
                        <?php if (Yii::$app->user->can('removerStock')): ?>
                            <?= Html::beginForm(['produtoloja/remove-stock', 'produtoId' => $produto->id, 'lojaId' => $lojaId], 'post') ?>
                            <?= Html::input('number', 'quantidade', 1, ['min' => 1, 'class' => 'form-control', 'style' => 'width: 80px; display: inline-block;']) ?>
                            <?= Html::submitButton('Remover Stock', ['class' => 'btn btn-danger']) ?>
                            <?= Html::endForm() ?>
                        <?php else: ?>
                            <p>Sem permissão</p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
$this->registerJs('$(".select2").select2();');
?>
