<?php
use yii\helpers\Html;

$this->title = $model->nome;
?>

    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/product_view.css') ?>">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="grid">
            <!-- Imagens do produto -->
            <div class="card">
                <!-- Exibir imagem -->
                <?php if ($model->imagem && file_exists(Yii::getAlias('@backend/web/uploads/' . $model->imagem->filename))): ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/' . $model->imagem->filename) ?>"
                         alt="<?= Html::encode($model->nome) ?>"
                         class="product img-fluid">
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@backendUrl/uploads/default.jpg') ?>"
                         alt="Imagem padrão"
                         class="product img-fluid">
                <?php endif; ?>
            </div>

            <!-- Detalhes do produto -->
            <div class="card product-details">
                <h2><?= Html::encode($model->nome) ?></h2>
                <?php
                $precoOriginal = $model->preco;
                $precoComDesconto = $precoOriginal;

                if ($model->produtoPromocao && $model->produtoPromocao->promocao) {
                    $promocao = $model->produtoPromocao->promocao;

                    // Verifica se a data de término da promoção não passou
                    $dataFim = new \DateTime($model->produtoPromocao->datafim);
                    $dataInicio = new \DateTime($model->produtoPromocao->datainicio);
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

                <div class="quantity-controls">

                    <?= Html::a('Adicionar ao Carrinho', ['carrinho/add', 'id' => $model->id], ['class' => 'btn-addcarrinho']) ?>
                </div>

                <hr>
                <div>
                    <?php foreach ($stock as $lojaId => $stockLoja): ?>
                        <p>Stock na Loja <?= $lojaId ?>: <?= $stockLoja ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Descrição do produto -->
        <div class="card product-description">
            <h3>Detalhes do Produto</h3>
            <p><?= Html::encode($model->descricao) ?></p>
        </div>
    </div>
<?php



