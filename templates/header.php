<?php // Sem o session_start(), pois ele já está no config.php ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WonderFly - Explore Culturas Autênticas</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="//code.jivosite.com/widget/g9s4rCzC8l" async></script>

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>./CSS/global.css" />
</head>

<body>
  <div class="topbar">
    <p>
      <span class="blink">●</span> Até 25% OFF nas experiências de verão — use
      o cupom <strong>WONDER25</strong>
    </p>
  </div>

  <header class="header">
    <a href="<?php echo BASE_URL; ?>./index.php" class="logo">
      <img src="<?php echo BASE_URL; ?>./images/white_logo.png" alt="WonderFly Logo" />
      <span>WonderFly</span>
    </a>

    <nav class="nav" id="nav">
      <a href="<?php echo BASE_URL; ?>./Avaliacoes/avaliacoes.php">Avaliações</a>
      <a href="<?php echo BASE_URL; ?>./Viagem/home_viagem.php">Destinos</a>
      <a href="<?php echo BASE_URL; ?>./Comunidade/home_comunidade.php">Comunidade</a>
      <a href="<?php echo BASE_URL; ?>./Blog/blog_home.php">Blog</a>
      <a href="<?php echo BASE_URL; ?>./Contato/contato.php">Contato</a>
    </nav>

    <div class="header-cta">
      <?php if (isset($_SESSION['user_id'])): ?>

        <a href="<?php echo BASE_URL; ?>./perfil/perfil.php" class="btn ghost">
          <i class="fa-solid fa-user"></i> Meu Perfil
        </a>
        <a href="<?php echo BASE_URL; ?>./logout.php" class="btn primary">Sair</a>

      <?php else: ?>

        <a href="<?php echo BASE_URL; ?>./Login/login.php" class="btn ghost">Fazer Login</a>
        <a href="<?php echo BASE_URL; ?>./Viagem/home_viagem.php"><button class="btn primary">Reserve Agora</button></a>

      <?php endif; ?>
    </div>

    <button class="burger" id="burger">
      <i class="fa-solid fa-bars"></i>
    </button>
  </header>