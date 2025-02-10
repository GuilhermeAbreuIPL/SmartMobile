<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <!-- Navbar -->
  <header>
    <div class="btnBar">
        <button class="openbtn" onclick="openSidebar('SidebarMenu')">☰</button>
    </div>
    <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="Logo">SmartMobile</a>
    <div class="Nav">
        <form action="<?= \yii\helpers\Url::to(['produto/search']) ?>" method="get">
            <div class="search-bar">
                    <input type="text" id="search-bar" name="search" placeholder="Procurar um produto" />
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
            </div>
        </form>


        <div class="navbar-icons">
        <!-- Perfil -->
          <svg class="iconClick" id="profile-button" onclick="openSidebar('SidebarProfile')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="4"></circle>
            <path d="M4 20c0-4 4-7 8-7s8 3 8 7"></path>
          </svg>




              <!-- Carrinho -->

            <svg class="iconClick" onclick="openSidebar('SidebarCart'); loadCart()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="21" r="1"></circle>
              <circle cx="20" cy="21" r="1"></circle>
              <path d="M1 1h4l2 14h13"></path>
              <path d="M16 5h5l-1 7H6"></path>
            </svg>
      </div>
    </div>
  </header>

  <!-- Backdrop -->
  <div id="backdrop" class="backdrop" onclick=""></div>

  <!-- Sidebar Menu-->
  <div id="SidebarMenu" class="sidebarMenu">
      <a href="#" class="closebtn" onclick="closeAllSidebars('SidebarMenu')">×</a>

      <h2>Categorias</h2>

      <!-- Exibir as categorias no Sidebar -->
      <div class="categories-sidebar">
          <?php
          $categorias = \common\models\Categoria::find()->all();

          function renderCategoryTree($categorias, $parentId = null)
          {
              // Variável para armazenar o HTML da lista de categorias
              $treeHtml = '<ul class="category-branch" data-parent-id="' . ($parentId ?? 'root') . '">';

              foreach ($categorias as $categoria) {
                  // Verifica se a categoria é uma categoria principal ou uma subcategoria
                  if ($categoria->categoria_principal_id == $parentId) {
                      $treeHtml .= '<li>';
                      $treeHtml .= yii\helpers\Html::a(
                          "{$categoria->nome}",
                          ['produto/search', 'categoria' => $categoria->id],  // Rota de pesquisa por categoria
                          [
                              'class' => 'category-link',
                              'data-id' => $categoria->id,
                          ]
                      );

                      $subcategorias = \common\models\Categoria::find()->where(['categoria_principal_id' => $categoria->id])->all();
                      if (!empty($subcategorias)) {
                          $treeHtml .= '<ul class="subcategory-list">';
                          foreach ($subcategorias as $subcategoria) {
                              $treeHtml .= '<li>';
                              $treeHtml .= yii\helpers\Html::a(
                                  "{$subcategoria->nome}",
                                  ['produto/search', 'categoria' => $subcategoria->id],  // Rota de pesquisa por categoria
                                  [
                                      'class' => 'category-link',
                                      'data-id' => $subcategoria->id,
                                  ]
                              );
                              $treeHtml .= '</li>';
                          }
                          $treeHtml .= '</ul>';
                      }

                      $treeHtml .= '</li>';
                  }
              }

              $treeHtml .= '</ul>';
              return $treeHtml;
          }

          // Renderiza as categorias principais e suas subcategorias no Sidebar
          echo renderCategoryTree($categorias);
          ?>
      </div>
  </div>



  <!-- Sidebar Profile -->
  <div id="SidebarProfile" class="sdCartProfile">
    <a href="#" class="closebtn" onclick="closeAllSidebars('SidebarProfile')">×</a>

    <div class="profile-content">
      <hr>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="container-white">
                <div class="user-info">
                    <h2>Olá, <?= Yii::$app->user->identity->username ?>!</h2>
                    <a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" class="btn-logout"
                       data-method="post">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="container-white">
                <h2>Olá! Faz já o teu Registo no smartmobile</h2>
                <div class="buttons">
                    <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>" class="btn-create">Criar conta</a>
                    <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="btn-login">Iniciar sessão</a>
                </div>
            </div>
        <?php endif; ?>
        <hr>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="menu">
                <a href="<?= \yii\helpers\Url::to(['user/view']) ?>">Dados pessoais</a>
                <a href="<?= \yii\helpers\Url::to(['fatura/index']) ?>">Minhas encomendas</a>
            </div>
        <?php endif; ?>
    </div>
  </div>

  <!-- Sidebar Cart -->
  <div id="SidebarCart" class="sdCartProfile">
    <a class="closebtn" onclick="closeAllSidebars('SidebarCart')">×</a>
    <h2 href="" id="teste" data-urlCarrinhoView="<?= \yii\helpers\Url::to(['carrinho/view']) ?>"> Carrinho</h2>
      <div id="cart-container"></div>
  </div>

</body>
</html>
