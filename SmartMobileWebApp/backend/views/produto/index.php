<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $produto): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header text-center">
                        <!-- Exibir o ID do produto antes do nome -->
                        <h5 class="card-title">
                            <?= Html::encode("{$produto->id} - {$produto->nome}") ?>
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <!-- Exibir imagem -->
                        <?php if ($produto->imagem && file_exists(Yii::getAlias('@webroot/uploads/' . $produto->imagem->filename))): ?>
                            <img src="<?= Url::to('@web/uploads/' . $produto->imagem->filename) ?>"
                                 alt="<?= Html::encode($produto->nome) ?>"
                                 class="img-fluid img-thumbnail"
                                 style="height: 200px; width: 100%;">
                        <?php else: ?>
                            <img src="<?= Url::to('@web/uploads/default.jpg') ?>"
                                 alt="Imagem padrão"
                                 class="img-fluid img-thumbnail"
                                 style="height: 200px; width: 100%;">
                        <?php endif; ?>

                        <!-- Exibir preço e descrição -->
                        <p class="mt-3"><strong>Preço:</strong> €<?= Html::encode($produto->preco) ?></p>
                        <p class="text-muted"><?= Html::encode($produto->descricao) ?></p>

                        <!-- Exibir o nome da categoria com link -->
                        <p><strong>Categoria:</strong>
                            <?php if ($produto->categoria): ?>
                                <?= Html::a(
                                    Html::encode($produto->categoria->nome),
                                    ['categoria/index', 'categoriaprincipalid' => $produto->categoria_id], // Link com o ID da categoria
                                    ['class' => 'text-primary']
                                ) ?>
                            <?php else: ?>
                                <em>Não categorizado</em>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <!-- Botões de ação -->
                        <?= Html::a('Editar', ['update', 'id' => $produto->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('Alterar Imagem', ['changeimage', 'id' => $produto->imagem_id], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= Html::a('Apagar', ['delete', 'id' => $produto->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Tem certeza de que deseja excluir este produto?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
