<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoria[] $categorias */
/** @var common\models\Categoria|null $categoriaPrincipal */
/** @var common\models\Categoria[] $breadcrumbs */

$this->title = $categoriaPrincipal ? "Subcategorias de {$categoriaPrincipal->nome}" : 'Categorias Principais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Exibir Breadcrumbs: Caminho das categorias -->
    <div class="breadcrumbs">
        <?php if (!empty($breadcrumbs)): ?>
            <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                <?= Html::a($breadcrumb->nome, $breadcrumb->id == 0 ? ['index'] : ['index', 'categoriaprincipalid' => $breadcrumb->id]) ?>
                <?php if ($index !== count($breadcrumbs) - 1): ?> > <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <p>
        <?php if ($categoriaPrincipal): ?>
            <?= Html::a('Criar Subcategoria', ['create', 'categoriaprincipalid' => $categoriaPrincipal->id], ['class' => 'btn btn-success']) ?>
        <?php else: ?>
            <?= Html::a('Criar Categoria Principal', ['create', 'categoriaprincipalid' => 0], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?= $categoria->id ?></td>
                <td><?= $categoria->nome ?></td>
                <td>
                    <?= Html::a('Ver Subcategorias', ['index', 'categoriaprincipalid' => $categoria->id], ['class' => 'btn btn-info btn-sm']) ?>
                    <?= Html::a('Adicionar Subcategoria', ['create', 'categoriaprincipalid' => $categoria->id], ['class' => 'btn btn-success btn-sm']) ?>
                    <?= Html::a('Editar', ['update', 'id' => $categoria->id], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Apagar', ['delete', 'id' => $categoria->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Tem certeza de que deseja excluir esta categoria?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
