<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/index.css') ?>">
<div class="row">
    <?php foreach ($dataProvider->getModels() as $produto): ?>
        <div class="col-md-auto">
            <div class="card">
                <div class="imgBox">
                    <!-- Exibir imagem -->
                    <?php if ($produto->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $produto->imagem->filename))): ?>
                        <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $produto->imagem->filename) ?>"
                             alt="<?= \yii\helpers\Html::encode($produto->nome) ?>"
                             class="product img-fluid">
                    <?php else: ?>
                        <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                             alt="Imagem padrão"
                             class="product img-fluid">
                    <?php endif; ?>
                </div>
                <div class="contentBox">
                    <h3><?= \yii\helpers\Html::encode($produto->nome) ?></h3>

                    <?php
                    $precoOriginal = $produto->preco;
                    $precoComDesconto = $precoOriginal;

                    if ($produto->produtoPromocao && $produto->produtoPromocao->promocao) {
                        $promocao = $produto->produtoPromocao->promocao;

                        // Verifica se a data de término da promoção não passou
                        $dataFim = new \DateTime($produto->produtoPromocao->datafim);
                        $dataInicio = new \DateTime($produto->produtoPromocao->datainicio);
                        $dataAtual = new \DateTime();

                        // Verifica se a promoção está dentro do período válido (data de início e data de fim)
                        if ($dataAtual >= $dataInicio && $dataAtual <= $dataFim) {
                            $desconto = ($promocao->descontopercentual / 100) * $precoOriginal;
                            $precoComDesconto = $precoOriginal - $desconto;
                        }
                    }
                    ?>

                    <h2 class="price">
                        <?php if ($precoComDesconto < $precoOriginal): ?>
                            <span style="text-decoration: line-through; font-size: 0.8em;">
                                <?= \yii\helpers\Html::encode(number_format($precoOriginal, 2)) ?> €
                            </span>
                        <?php endif; ?>
                        <?= \yii\helpers\Html::encode(number_format($precoComDesconto, 2)) ?><small> €</small>
                    </h2>

                    <?= \yii\helpers\Html::a('Mais detalhes', ['view', 'id' => $produto->id], ['class' => 'btnInfo']) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="<?= Yii::getAlias('@web/js/index.js') ?>"></script>
