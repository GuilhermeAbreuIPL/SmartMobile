
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
            <div class="brand-link">
                <img src="<?= Yii::$app->request->baseUrl ?>/img/smartmobile_logo.png" alt="SmartMobile Logo" class="brand-image" style="opacity: .8; height: 40px;">
            </div>
            <div class="info mt-2 d-flex align-items-center">
                <!-- Imagem KEKW ajustada para o mesmo tamanho da logo -->
                <img src="<?= Yii::$app->request->baseUrl ?>/img/kekw_image.png" alt="KEKW" class="img-circle mr-2" style="height: 40px; width: 40px;">
                <!-- Nome do usuário sem a tag <a>, com texto branco -->
                <span class="d-block" style="font-size: 16px; font-weight: 600; color: #c2c7d0; margin-left: 10px;"><?= Yii::$app->user->identity->userprofile->nome ?></span>
            </div>
        </div>




        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    //header dashboard
                    ['label' => 'Dashboard', 'header' => true],
                    ['label' => 'Smart Mobile', 'icon' => 'tachometer-alt', 'url' => ['site/index']],

                    [
                        'label' => 'Feramentas Yii2',
                        'icon' => 'tools',
                        'items' => [
                            ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                            ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                        ]
                    ],

                    //Gestao de Contas e Roles
                    ['label' => 'Gestão Roles', 'header' => true],
                    ['label' => 'Gerir Contas', 'url' => ['user/index'],
                        'visible' => Yii::$app->user->can('viewallprofiles')
                    ],

                    //header gestao geral
                    ['label' => 'Gestão Geral', 'header' => true],

                    //fornecedores
                    ['label' => 'Fornecedores', 'url' => ['fornecedor/index'],
                        'visible' => Yii::$app->user->can('viewfornecedor'),
                    ],

                    //lojas
                    ['label' => 'Lojas', 'url' => ['loja/index'],
                        'visible' => Yii::$app->user->can('viewloja')
                    ],

                    //metodo pagamento
                    ['label' => 'Métodos de Pagamento', 'url' => ['metodopagamento/index'],
                       'visible' => Yii::$app->user->can('viewMetodoPagamento')
                    ],

                    //metodo entrega
                    ['label' => 'Métodos de Entrega', 'url' => ['metodoentrega/index'],
                        'visible' => Yii::$app->user->can('viewMetodoEntrega')
                    ],

                    //header gestao produtos
                    ['label' => 'Gestão Produtos', 'header' => true],
                    ['label' => 'Vista Produtos', 'url' => ['produto/index'] /*prems aqui*/],



                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
