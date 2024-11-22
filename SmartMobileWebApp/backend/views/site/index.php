<?php
$this->title = 'Smart Mobile Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '15',
                'text' => 'Novas encomendas',
                'icon' => 'fas fa-shopping-cart',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '150',
                'text' => 'Encomendas terminadas',
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'success'
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '44',
                'text' => 'Clientes registados',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                //'loadingStyle' => true
            ]) ?>
        </div>
    </div>
</div>