<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WonderFly - Explore Culturas Autênticas</title>

    <link rel="stylesheet" href="/CSS/global.css" />
</head>

<body>
    <div class="topbar">
        <p>
            <span class="blink">●</span> Até 25% OFF nas experiências de verão — use
            o cupom <strong>WONDER25</strong>
        </p>
    </div>

    <header class="header">
        <a href="./index.php" class="logo">
            <img src="./images/white_logo.png" alt="" />
            <span>WonderFly</span>
        </a>
        <nav class="nav">
            <a href="./Viagem/home_viagem.php">Destinos</a>
            <a href="./Comunidade/home_comunidade.php">Comunidade</a>
            <a href="./Blog/blog_home.php">Blog</a>
            <a href="./Contato/contato.php">Contato</a>
        </nav>

        <div class="header-cta">
            <?php if (isset($_SESSION['user_id'])): ?>

                <a href="./perfil/perfil.php" class="btn ghost">
                    <i class="fa-solid fa-user"></i> Meu Perfil
                </a>
                <a href="./logout.php" class="btn primary">Sair</a>

            <?php else: ?>

                <a href="./Login/login.php" class="btn ghost">Fazer Login</a>
                <a href="./Viagem/home_viagem.php"><button class="btn primary">Reserve Agora</button></a>

            <?php endif; ?>
        </div>

        <button class="burger">
            <i class="fa-solid fa-bars"></i>
        </button>
    </header>