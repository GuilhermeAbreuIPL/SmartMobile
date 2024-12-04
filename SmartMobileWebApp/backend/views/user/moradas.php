<?php
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $user common\models\User */
/** @var $moradas common\models\Morada[] */

$this->title = "Moradas de {$user->username}";
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
        <th>Rua</th>
        <th>Localidade</th>
        <th>Código Postal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($moradas as $index => $morada): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= Html::encode($morada->id) ?></td>
            <td><?= Html::encode($morada->rua) ?></td>
            <td><?= Html::encode($morada->localidade) ?></td>
            <td><?= Html::encode($morada->codpostal) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

