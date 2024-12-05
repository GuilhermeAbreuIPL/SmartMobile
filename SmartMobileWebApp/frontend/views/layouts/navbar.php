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
      <div class="search-bar">
            <input type="text" placeholder="Hinted search text" />
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
      </div>
      <div class="navbar-icons">
        <!-- Modo escuro -->
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>

        <!-- Alternador -->
        <label class="toggle">
          <input type="checkbox" />
          <span class="slider"></span>
        </label>

        <!-- Modo claro -->
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"></circle>
          <line x1="12" y1="1" x2="12" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="23"></line>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
          <line x1="1" y1="12" x2="3" y2="12"></line>
          <line x1="21" y1="12" x2="23" y2="12"></line>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>

        <!-- Perfil -->
          <svg class="iconClick"  onclick="openSidebar('SidebarProfile')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="4"></circle>
            <path d="M4 20c0-4 4-7 8-7s8 3 8 7"></path>
          </svg>


        <!-- Carrinho -->
        <svg class="iconClick" onclick="openSidebar('SidebarCart')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
  </div>

  <!-- Sidebar Profile -->
  <div id="SidebarProfile" class="sdCartProfile">
    <a href="#" class="closebtn" onclick="closeAllSidebars('SidebarProfile')">×</a>

    <div class="profile-content">
      <hr>
      <div class="container-white">
        <h2>Olá! Faz já o teu Registo no smartmobile</h2>
        <div class="buttons">
          <a href="<?= \yii\helpers\Url::to(['site/signup'])?>" class="btn-create">Criar conta</a>
          <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="btn-login">Iniciar sessão</a>
        </div>
      </div>
      <hr>
      <div class="menu">
        <a href="<?= \yii\helpers\Url::to(['user/view'])?>">Dados pessoais</a>
        <a href="<?= \yii\helpers\Url::to(['site/#'])?>">Minhas encomendas</a>
      </div>
    </div>
  </div>

  <!-- Sidebar Cart -->
  <div id="SidebarCart" class="sdCartProfile">
    <a href="#" class="closebtn" onclick="closeAllSidebars('SidebarCart')">×</a>
    <a href="#">Cart</a>
  </div>

</body>
</html>
