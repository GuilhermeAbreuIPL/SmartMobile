<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
?>
<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/about.css') ?>">

<div class="container conteudo">
    <div class="row text-center py-3">
        <div class="col-md-12">
            <p class="banner-txt">Quem nós somos?</p>
            <p class="banner-txt-min">3 alunos de um CeTSP de Programação</p>
        </div>
    </div>
    <div class="row">
        <div class="col person">
            <div class="muldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Pedro André Santos Latado</p>
                <p>Nº 2231619</p>
            </div>
        </div>
        <div class="col person">
            <div class="muldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Pedro Gaspar</p>
                <p>Nº 2231991</p>
            </div>
        </div>
        <div class="col person">
            <div class="muldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Guilherme Nunes Abreu</p>
                <p>Nº 2232352</p>
            </div>
        </div>
    </div>
</div>

