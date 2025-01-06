<?php
/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/index.css') ?>">

<div class="site-index">
    <div class="slideshow-container">
        <div class="slide fade">
            <img src="https://via.placeholder.com/1920x1080?text=Slide+1" alt="Slide 1">
        </div>
        <div class="slide fade">
            <img src="https://via.placeholder.com/1920x1080?text=Slide+2" alt="Slide 2">
        </div>
        <div class="slide fade">
            <img src="https://via.placeholder.com/1920x1080?text=Slide+3" alt="Slide 3">
        </div>
    </div>

    <div class="FastAccess-container">
        <div class="col espaco">
            <div class="icon-item">
                <a href="<?= \yii\helpers\Url::to(['produto/search?categoria=1']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92V19a2 2 0 0 1-2.18 2A19.86 19.86 0 0 1 3 5.18 2 2 0 0 1 5 3h2.09a2 2 0 0 1 2 1.72 12.4 12.4 0 0 0 .57 2.53 2 2 0 0 1-.45 2L8 10a16 16 0 0 0 6 6l.75-.75a2 2 0 0 1 2-.45 12.4 12.4 0 0 0 2.52.57 2 2 0 0 1 1.73 2.05z"></path>
                    </svg>
                </a>
                <p>Telemóveis</p>
            </div>
        </div>
        <div class="col espaco">
            <div class="icon-item">
                <a href="<?= \yii\helpers\Url::to(['produto/search?categoria=12']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 6v6l4 2"></path>
                    </svg>
                </a>
                <p>Relógios</p>
            </div>
        </div>
        <div class="col espaco">
            <div class="icon-item">
                <a href="<?= \yii\helpers\Url::to(['produto/search?categoria=13']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 7L12 2L21 7L12 12L3 7Z" />
                        <path d="M3 7V17L12 22L21 17V7" />
                        <path d="M12 12L12 22" />
                    </svg>
                </a>
                <p>Acessórios</p>
            </div>
        </div>
    </div>

    <div class="body-content">
        <?= Yii::$app->runAction('//produto/index') ?>
    </div>

<script src="<?= Yii::getAlias('@web/js/index.js') ?>"></script>