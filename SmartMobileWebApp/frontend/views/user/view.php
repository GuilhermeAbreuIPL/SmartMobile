<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Userprofile $profile */
/** @var string $role */

$this->title = 'Meu Perfil';
?>
<div class="user-view">
    <!-- Título da página -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Botão para editar o perfil -->
    <p>
        <?= Html::a('Editar', ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que deseja apagar o seu perfil?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <!-- Informações do utilizador -->
    <div class="user-details-widget">
        <h2>Detalhes do perfil:</h2>
        <table class="table table-bordered">
            <!-- Linha para Nome -->
            <tr>
                <th>Nome</th>
                <td><?= Html::encode($profile->nome ?? 'Não definido') ?></td>
            </tr>
            <!-- Linha para Username -->
            <tr>
                <th>Username</th>
                <td><?= Html::encode($user->username ?? 'Não definido') ?></td>
            </tr>
            <!-- Linha para Email -->
            <tr>
                <th>Email</th>
                <td><?= Html::encode($user->email ?? 'Não definido') ?></td>
            </tr>
            <!-- Linha para NIF -->
            <tr>
                <th>NIF</th>
                <td><?= Html::encode($profile->nif ?? 'Não definido') ?></td>
            </tr>
            <!-- Linha para Telemóvel -->
            <tr>
                <th>Telemóvel</th>
                <td><?= Html::encode($profile->telemovel ?? 'Não definido') ?></td>
            </tr>
        </table>
    </div>
    <h1>Moradas</h1>
    <div class="morada-list">
        <?php foreach ($moradas as $morada): ?>
            <div class="morada-card">
                <p><strong>Rua:</strong> <?= Html::encode($morada->rua) ?></p>
                <p><strong>Localidade:</strong> <?= Html::encode($morada->localidade) ?></p>
                <p><strong>Código Postal:</strong> <?= Html::encode($morada->codpostal) ?></p>
                <?= Html::a('Editar', ['manage-morada', 'moradaId' => $morada->id], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endforeach; ?>

        <?php if (count($moradas) < 3): ?>
            <div class="morada-card">
                <?= Html::a('+ Adicionar Nova Morada', ['manage-morada'], ['class' => 'btn btn-success']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
