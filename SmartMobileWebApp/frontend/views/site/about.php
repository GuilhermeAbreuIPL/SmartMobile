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
            <div class="moldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Pedro André Santos Latado</p>
                <p>Nº 2231619</p>
            </div>
        </div>
        <div class="col person">
            <div class="moldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Pedro Gaspar</p>
                <p>Nº 2231991</p>
            </div>
        </div>
        <div class="col person">
            <div class="moldura">
                <img src="#" class="img-responsive" alt="...">
            </div>
            <div class="info-perfil">
                <p>Guilherme Nunes Abreu</p>
                <p>Nº 2232352</p>
            </div>
        </div>
    </div>

    <div class="container-map">
        <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3823.304714382037!2d-8.825806751847267!3d39.73443926765741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22735a4e067afb%3A0xcfaf619f4450fa76!2sPolit%C3%A9cnico%20de%20Leiria%20%7C%20ESTG%20-%20Escola%20Superior%20de%20Tecnologia%20e%20Gest%C3%A3o_Edif%C3%ADcio%20D!5e1!3m2!1spt-PT!2spt!4v1733326631699!5m2!1spt-PT!2spt" class="google-map" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
