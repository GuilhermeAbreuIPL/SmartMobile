<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = 'Criar Produto';
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


function renderCategoryTreeWithExpand($categorias, $parentId = null, $selectedCategoryId = null)
{
    $treeHtml = '<ul class="category-branch" data-parent-id="' . ($parentId ?? 'root') . '" style="' . ($parentId ? 'display: none;' : '') . '">';
    foreach ($categorias as $categoria) {
        if ($categoria->categoria_principal_id == $parentId) {
            $isSelected = $categoria->id == $selectedCategoryId ? 'font-weight: bold; color: green;' : '';
            $treeHtml .= '<li>';
            $treeHtml .= Html::a(
                "{$categoria->nome} (ID: {$categoria->id})",
                '#',
                [
                    'class' => 'category-link',
                    'data-id' => $categoria->id,
                    'style' => $isSelected,
                ]
            );

            $hasChildren = false;
            foreach ($categorias as $subcategoria) {
                if ($subcategoria->categoria_principal_id == $categoria->id) {
                    $hasChildren = true;
                    break;
                }
            }
            if ($hasChildren) {
                $treeHtml .= Html::button('+', [
                    'class' => 'expand-button',
                    'data-id' => $categoria->id,
                ]);
            }

            $treeHtml .= renderCategoryTreeWithExpand($categorias, $categoria->id, $selectedCategoryId);
            $treeHtml .= '</li>';
        }
    }
    $treeHtml .= '</ul>';
    return $treeHtml;
}

$categoryTreeHtml = renderCategoryTreeWithExpand($categorias, null, $model->categoria_id);
?>
<div class="produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="produto-form">

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preco')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descricao')->textarea(['rows' => 6])->label('Descrição') ?>

        <div class="form-group">
            <label id="selected-category-label" style="display: none;"><strong>Categoria Selecionada:</strong></label>
            <div id="selected-category" class="selected-category" style="display: none;">
                <span id="selected-category-name" class="selected-category-name"></span>
                <?= Html::button('Limpar', ['id' => 'clear-category', 'class' => 'btn btn-danger btn-sm']) ?>
            </div>
        </div>

        <?= $form->field($model, 'categoria_id')->hiddenInput(['id' => 'produto-categoria_id'])->label(false) ?>

        <div class="form-group category-tree-container">
            <label><strong>Selecione uma Categoria:</strong></label>
            <div class="category-tree">
                <?= $categoryTreeHtml ?>
            </div>
        </div>

        <div>
            <label><strong>Imagem:</strong></label>

            <?= $form->field($model, 'filename')->fileInput()->label(false) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Criar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <script src="<?= Yii::getAlias('@web/js/produto.js') ?>"></script>
</div>
