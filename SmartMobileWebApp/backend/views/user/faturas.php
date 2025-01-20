<?php
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $user common\models\User */
/** @var $moradas common\models\Fatura[] */

$this->title = "Faturas de {$user->username}";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Utilizador:</strong> <?= Html::encode($user->username) ?></p>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>ID</th>
        <th>Data Fatura</th>
        <th>Total</th>
        <th>Status Order</th>
        <th>Metodo de Pagamento</th>
        <th>Tipo Entrega</th>
        <th>Morada De Expedição</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($faturas as $index => $fatura): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $fatura->id ?></td>
            <td><?= $fatura->datafatura ?></td>
            <td><?= $fatura->total ?></td>
            <td><?= $fatura->statusorder ?></td>
            <td><?= Html::encode($fatura->metodopagamento->nome) ?></td>
            <td><?= $fatura->tipoentrega ?></td>
            <td>
                <?= Html::encode($fatura->moradaexpedicao->rua) ?>
                <?= Html::encode($fatura->moradaexpedicao->codpostal) ?>
                <?= Html::encode($fatura->moradaexpedicao->localidade) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

