<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Userprofile $profile */
/** @var string $role */

$this->title = 'Dados Pessoais';
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/config.css') ?>">



<div class="main-content">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-view">
        <!-- Detalhes do usuário -->
        <div class="user-details-widget">

            <div class="logo-box">
                <a class="text">SmartMobile</a>
            </div>


            <div class="user-box"
                <div class="user-info">
                    <p><strong>Nome:</strong> <?= Html::encode($profile->nome ?? 'Não definido') ?></p>
                    <p><strong>Username:</strong> <?= Html::encode($user->username ?? 'Não definido') ?></p>
                    <p><strong>Email:</strong> <?= Html::encode($user->email ?? 'Não definido') ?></p>
                    <p><strong>NIF:</strong> <?= Html::encode($profile->nif ?? 'Não definido') ?></p>
                    <p><strong>Telemóvel:</strong> <?= Html::encode($profile->telemovel ?? 'Não definido') ?></p>

                    <?= Html::a('Editar', ['update'], ['class' => 'btn-edit-dados']) ?>
                    <?= Html::a('Apagar', ['delete'], [
                        'class' => 'btn-edit-dados',
                        'data' => [
                            'confirm' => 'Tem a certeza que deseja apagar o seu perfil?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>

        </div>

        <!-- Lista de moradas -->
        <div class="morada-list">
            <h2 class="section-title">Moradas</h2>

            <?php foreach ($moradas as $morada): ?>
                <!-- Cartão de morada existente -->
                <div class="morada-card" data-id="<?= $morada->id ?>">
                    <p><strong>Rua:</strong> <?= Html::encode($morada->rua) ?></p>
                    <p><strong>Localidade:</strong> <?= Html::encode($morada->localidade) ?></p>
                    <p><strong>Código Postal:</strong> <?= Html::encode($morada->codpostal) ?></p>
                </div>
            <?php endforeach; ?>

            <?php
            // Exibe as caixas vazias restantes para completar 3 no total
            $emptyCards = 3 - count($moradas);
            for ($i = 0; $i < $emptyCards; $i++): ?>
                <div class="morada-card add-new-card">
                    <span class="plus-icon">+</span>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<script src="<?= Yii::getAlias('@web/js/config.js') ?>"></script>


