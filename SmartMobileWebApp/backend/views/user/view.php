<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var app\models\Userprofile $profile */
/** @var string $role */

// Título da página e breadcrumbs
$this->title = $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Guarda que este foi o ultimo url
Yii::$app->session->set('lastUrl', Yii::$app->request->url);

?>

<div class="user-view">

    <!-- Título principal -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Botões de ação: Atualizar e Apagar -->
    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tens a certeza que queres apagar este utilizador?',
                'method' => 'post',
            ],
        ]) ?>
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

    <!-- Widget para apresentar os detalhes do utilizador -->
    <div class="user-details-widget">
        <h2>Detalhes do Utilizador</h2>
        <table class="table table-bordered">
            <!-- Linha para ID -->
            <tr>
                <th>ID</th>
                <td><?= Html::encode($user->id ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Username -->
            <tr>
                <th>Username</th>
                <td><?= Html::encode($user->username ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Email -->
            <tr>
                <th>Email</th>
                <td><?= Html::encode($user->email ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Auth Key -->
            <tr>
                <th>Auth Key</th>
                <td><?= Html::encode($user->auth_key ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Data de Criação -->
            <tr>
                <th>Criado em</th>
                <td><?= isset($user->created_at) ? Yii::$app->formatter->asDatetime($user->created_at) : 'Not set' ?></td>
            </tr>
            <!-- Linha para Data de Atualização -->
            <tr>
                <th>Atualizado em</th>
                <td><?= isset($user->updated_at) ? Yii::$app->formatter->asDatetime($user->updated_at) : 'Not set' ?></td>
            </tr>
            <!-- Linha para Role -->
            <tr>
                <th>Role</th>
                <td><?= Html::encode($role ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Nome -->
            <tr>
                <th>Nome</th>
                <td><?= Html::encode($profile->nome ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para NIF -->
            <tr>
                <th>NIF</th>
                <td><?= Html::encode($profile->nif ?? 'Not set') ?></td>
            </tr>
            <!-- Linha para Telemóvel -->
            <tr>
                <th>Telemóvel</th>
                <td><?= Html::encode($profile->telemovel ?? 'Not set') ?></td>
            </tr>
            <tr>
                <th>Morada/s</th>
                <td><?= Html::a('Ver', ['moradas', 'id' => $user->id], ['class' => 'btn btn-secondary btn-sm']) ?></td>
            </tr>
        </table>
    </div>
</div>
