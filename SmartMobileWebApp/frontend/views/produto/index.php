<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/index.css') ?>">
<div class="row">
    <?php foreach ($dataProvider->getModels() as $produto): ?>
        <div class="col-md-auto">
            <div class="card" id="card-<?=$produto->id ?>">
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
                <div class="contentBox" id="content-<?=$produto->id ?>">
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

                    <div class="btnContainer">
                        <?= \yii\helpers\Html::a('Mais detalhes', ['view', 'id' => $produto->id], ['class' => 'btnInfo']) ?>

                        <?= \yii\helpers\Html::a(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.8 12.4a1 1 0 0 0 1 0.6h12a1 1 0 0 0 1-.8L23 6H6"></path>
                            </svg>',
                            ['carrinho/add', 'id' => $produto->id],
                            ['class' => 'btnCart', 'id' => 'cart-btn-' . $produto->id]
                        ) ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="<?= Yii::getAlias('@web/js/index.js') ?>"></script>
