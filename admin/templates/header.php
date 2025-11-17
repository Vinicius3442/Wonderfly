<?php
$active_slug = $page_slug ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Dashboard'; ?> | WonderFly</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/admin_style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/css/admin_style.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
</head>
<body>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="<?php echo BASE_URL; ?>admin/index.php" class="sidebar-logo">
            <img src="<?php echo BASE_URL; ?>images/logo.png" alt="WonderFly Logo">
            <span>Admin <span style="color: rgb(22, 123, 191);">Wonder</span><span class="orange"> Fly</span></span>
        </a>
        
        <nav class="sidebar-nav">
            <span class="sidebar-nav-title">Principal</span>
            <a href="<?php echo BASE_URL; ?>admin/index.php" 
               class="<?php echo ($active_slug === 'dashboard') ? 'active' : ''; ?>">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            
            <span class="sidebar-nav-title">Gerenciamento</span>
            <a href="<?php echo BASE_URL; ?>admin/gerir_viagens.php" 
               class="<?php echo ($active_slug === 'gerir_viagens') ? 'active' : ''; ?>">
                <i class="ri-map-pin-line"></i> Gerir Viagens
            </a>
            <a href="#" class="<?php echo ($active_slug === 'gerir_blog') ? 'active' : ''; ?>">
                <i class="ri-article-line"></i> Gerir Blog
            </a>
            <a href="#" class="<?php echo ($active_slug === 'gerir_usuarios') ? 'active' : ''; ?>">
                <i class="ri-user-line"></i> Gerir Usuários
            </a>
            <a href="#" class="<?php echo ($active_slug === 'moderar_forum') ? 'active' : ''; ?>">
                <i class="ri-discuss-line"></i> Moderar Fórum
            </a>

            <span class="sidebar-nav-title">Visualização</span>
             <a href="#" class="<?php echo ($active_slug === 'ver_reservas') ? 'active' : ''; ?>">
                <i class="ri-shopping-cart-line"></i> Ver Reservas
            </a>
            <a href="#" class="<?php echo ($active_slug === 'ver_avaliacoes') ? 'active' : ''; ?>">
                <i class="ri-star-line"></i> Ver Avaliações
            </a>
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-header">
            <a href="<?php echo BASE_URL; ?>index.php" class="btn secondary" target="_blank">
                <i class="ri-external-link-line"></i> Ver Site
            </a>
            <div class="admin-profile">
                <i class="ri-user-fill"></i>
                <span><?php echo htmlspecialchars($admin_nome ?? 'Admin'); ?></span>
            </div>
            <a href="<?php echo BASE_URL; ?>logout.php" class="btn primary">Sair</a>
        </header>

        <div class="admin-content"></div>