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

    <div class="body-content">
        <div class="row">
            <div class="col-md-auto">
                <div class="card">
                    <div class="imgBox">
                        <img src="https://raw.githubusercontent.com/hdpngworld/HPW/main/uploads/6503838502c49-iphone%2015%20blue.png" alt="Product" class="product">
                    </div>
                    <div class="contentBox">
                        <h3>Iphone cenas</h3>
                        <h2 class="price">61.<small>98</small> €</h2>
                        <a href="#" class="btnInfo">Mais detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-auto">
                <div class="card">
                    <div class="imgBox">
                        <img src="https://png.pngtree.com/png-vector/20240728/ourmid/pngtree-abstract-art-phone-case-for-iphone-png-image_13267490.png" alt="Product" class="product">
                    </div>
                    <div class="contentBox">
                        <h3>Capa cenas</h3>
                        <h2 class="price">61.<small>98</small> €</h2>
                        <a href="#" class="btnInfo">Mais detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-auto">
                <div class="card">
                    <div class="imgBox">
                        <img src="https://png.pngtree.com/png-clipart/20230508/original/pngtree-airpods-png-image_9149137.png" alt="Product" class="product">
                    </div>
                    <div class="contentBox">
                        <h3>Airpods cenas</h3>
                        <h2 class="price">61.<small>98</small> €</h2>
                        <a href="#" class="btnInfo">Mais detalhes</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-auto">
                <div class="card">
                    <div class="imgBox">
                        <img src="https://png.pngtree.com/png-vector/20240728/ourmid/pngtree-abstract-art-phone-case-for-iphone-png-image_13267490.png" alt="Product" class="product">
                    </div>
                    <div class="contentBox">
                        <h3>Capa cenas</h3>
                        <h2 class="price">61.<small>98</small> €</h2>
                        <a href="#" class="btnInfo">Mais detalhes</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="<?= Yii::getAlias('@web/js/index.js') ?>"></script>