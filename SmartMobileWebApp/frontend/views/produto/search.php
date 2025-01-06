<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/index.css') ?>">
<div class="row">
    <div class="col-12 mb-4">
        <h2>
            Resultados da Pesquisa
            <?php if ($search): ?>
                para "<strong><?= \yii\helpers\Html::encode($search) ?></strong>"
            <?php endif; ?>
            <?php if ($categoria): ?>
                na categoria "<strong><?= \yii\helpers\Html::encode($categoria) ?></strong>"
            <?php endif; ?>
        </h2>
    </div>

    <?php if (empty($produtos)): ?>
        <div class="col-12">
            <p class="text-center">Nenhum produto encontrado.</p>
        </div>
    <?php else: ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-auto">
                <div class="card">
                    <div class="imgBox">
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
                            $dataFim = new \DateTime($produto->produtoPromocao->datafim);
                            $dataInicio = new \DateTime($produto->produtoPromocao->datainicio);
                            $dataAtual = new \DateTime();

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
                                ['class' => 'btnCart']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="<?= Yii::getAlias('@web/js/index.js') ?>"></script>
