<?php
use yii\helpers\Html;

$this->title = $model->nome;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>Preço:</strong> <?= Yii::$app->formatter->asCurrency($model->preco) ?></p>
    <p><strong>Descrição:</strong> <?= Html::encode($model->descricao) ?></p>

<?= Html::a('Adicionar ao Carrinho', ['add-to-cart', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
<?php
