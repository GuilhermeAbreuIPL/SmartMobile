<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
            <div class="brand-link">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/smartmobile_logo.png" alt="SmartMobile Logo" class="brand-image" style="opacity: .8; height: 40px;">
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    // Header dashboard
                    ['label' => 'Dashboard', 'header' => true],
                    ['label' => 'Smart Mobile', 'icon' => 'tachometer-alt', 'url' => ['site/index']],

                    // Feramentas Yii2
                    [
                        'label' => 'Feramentas Yii2',
                        'icon' => 'tools',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                            ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                        ]
                    ],

                    // Gestão de Contas e Roles
                    ['label' => 'Gestão Roles', 'header' => true],
                    ['label' => 'Gerir Contas', 'icon' => 'users', 'url' => ['user/index'], 'visible' => Yii::$app->user->can('viewallprofiles')],

                    // Gestão Geral
                    ['label' => 'Gestão Geral', 'header' => true],

                    // Fornecedores
                    ['label' => 'Fornecedores', 'icon' => 'industry', 'url' => ['fornecedor/index'], 'visible' => Yii::$app->user->can('viewfornecedor')],

                    // Lojas
                    ['label' => 'Lojas', 'icon' => 'store', 'url' => ['loja/index'], 'visible' => Yii::$app->user->can('viewloja')],

                    // Métodos de Pagamento
                    ['label' => 'Métodos de Pagamento', 'icon' => 'credit-card', 'url' => ['metodopagamento/index'], 'visible' => Yii::$app->user->can('viewMetodoPagamento')],

                    // Categorias
                    ['label' => 'Categorias', 'icon' => 'tags', 'url' => ['categoria/index'], 'visible' => Yii::$app->user->can('viewCategoria')],

                    // Promoções
                    ['label' => 'Promoções', 'icon' => 'gift', 'url' => ['promocao/index'], 'visible' => Yii::$app->user->can('viewPromocao')],

                    // Produtos
                    ['label' => 'Produtos', 'icon' => 'box', 'url' => ['produto/index'], 'visible' => Yii::$app->user->can('updateProduto')],

                    // Promoção Produtos
                    ['label' => 'Promoção Produtos', 'icon' => 'percentage', 'url' => ['produtopromocao/index'], 'visible' => Yii::$app->user->can('viewPromocao')],

                    // Stock Lojas
                    ['label' => 'Stock Lojas', 'icon' => 'warehouse', 'url' => ['produtoloja/index'], 'visible' => Yii::$app->user->can('viewstock')],

                    // Compras Loja
                    ['label' => 'Compras Loja', 'icon' => 'shopping-cart', 'url' => ['compraloja/index'], 'visible' => Yii::$app->user->can('viewcompraloja')],

                    // Faturas
                    ['label' => 'Faturas', 'icon' => 'file-invoice', 'url' => ['fatura/index'], 'visible' => Yii::$app->user->can('viewcompraloja')],
                ],
            ]);
            ?>
        </nav>
    </div>
</aside>
