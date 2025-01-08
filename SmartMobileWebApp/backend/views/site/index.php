<?php
$this->title = 'Smart Mobile Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <!-- Encomendas Pendentes -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $faturasPendentes,
                'text' => 'Encomendas pendentes',
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'warning',  // Alerta (cor amarela para atenção)
            ]) ?>
        </div>

        <!-- Encomendas Concluídas -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $faturasConcluidas,
                'text' => 'Encomendas terminadas',
                'icon' => 'fas fa-check-circle',
                'theme' => 'success',  // Sucesso (verde para concluir)
            ]) ?>
        </div>

        <!-- Clientes Registados -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $clientesRegistados,
                'text' => 'Clientes registados',
                'icon' => 'fas fa-user-plus',
                'theme' => 'info',  // Informativo (azul para dados)
            ]) ?>
        </div>

        <!-- Rendimento Total -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $rendimentoTotal . '$',
                'text' => 'Facturação total',
                'icon' => 'fas fa-dollar-sign',
                'theme' => 'secondary',  // Secundário (cinza para dados gerais)
            ]) ?>
        </div>

        <!-- Produtos a venda -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $produtosVenda,
                'text' => 'Produtos a venda',
                'icon' => 'fas fa-shopping-basket',
                'theme' => 'danger',  // Perigo (vermelho para alerta)
            ]) ?>
        </div>

        <!-- Promoções Ativas -->
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $promoAtivas,
                'text' => 'Promoções ativas',
                'icon' => 'fas fa-tags',
                'theme' => 'success',  // Sucesso (verde para concluir)
            ]) ?>
        </div>
    </div>
</div>
