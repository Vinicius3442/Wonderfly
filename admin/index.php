<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../Login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/dashboard.js" defer></script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../images/logo.png" alt="WonderFly Logo" style="height: 40px; margin-right: 10px;">
            <span>WonderFly</span>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-item active">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            <a href="blog.php" class="nav-item">
                <i class="ri-article-line"></i> Blog
            </a>
            <a href="forum.php" class="nav-item">
                <i class="ri-discuss-line"></i> Fórum
            </a>
            <a href="users.php" class="nav-item">
                <i class="ri-user-line"></i> Usuários
            </a>
            <a href="trips.php" class="nav-item">
                <i class="ri-map-pin-line"></i> Viagens
            </a>
            <a href="reviews.php" class="nav-item">
                <i class="ri-star-line"></i> Avaliações
            </a>
            <a href="../index.php" class="nav-item">
                <i class="ri-arrow-left-line"></i> Voltar ao Site
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header-bar">
            <div class="header-title">
                <h1>Dashboard</h1>
            </div>
            <div class="user-profile">
                <span id="admin-name">Admin</span>
                <img id="admin-avatar" src="../images/profile/default.jpg" alt="Admin" class="user-avatar">
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ri-user-smile-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-users">-</h3>
                    <p>Usuários Totais</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196F3;">
                    <i class="ri-article-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-posts">-</h3>
                    <p>Artigos Publicados</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #FFC107;">
                    <i class="ri-map-pin-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-trips">-</h3>
                    <p>Viagens Ativas</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(156, 39, 176, 0.1); color: #9C27B0;">
                    <i class="ri-message-3-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-topics">-</h3>
                    <p>Tópicos no Fórum</p>
                </div>
            </div>
        </div>

        <!-- New Widgets Section -->
        <div class="widgets-container">
            <!-- Row 1: Currency & Weather -->
            <div class="widget-row">
                <div class="dashboard-card widget-half">
                    <div class="card-header">
                        <h3><i class="ri-money-dollar-circle-line"></i> Cotações (Hoje)</h3>
                    </div>
                    <div id="currency-widget" class="widget-content">
                        <p>Carregando...</p>
                    </div>
                </div>
                <div class="dashboard-card widget-half">
                    <div class="card-header">
                        <h3><i class="ri-sun-line"></i> Clima Global</h3>
                    </div>
                    <div id="weather-widget" class="widget-content">
                        <p>Carregando...</p>
                    </div>
                </div>
            </div>

            <!-- Row 2: Map & Feed -->
            <div class="widget-row">
                <div class="dashboard-card widget-two-thirds">
                    <div class="card-header">
                        <h3><i class="ri-earth-line"></i> Usuários Ativos (Tempo Real)</h3>
                    </div>
                    <div id="users-map" style="height: 400px; border-radius: 8px;"></div>
                </div>
                <div class="dashboard-card widget-one-third">
                    <div class="card-header">
                        <h3><i class="ri-notification-3-line"></i> Atividades Recentes</h3>
                    </div>
                    <div id="activity-feed" class="widget-content scrollable-feed">
                        <p>Carregando...</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .widgets-container {
                margin-top: 30px;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .widget-row {
                display: flex;
                gap: 20px;
            }
            .widget-half { flex: 1; }
            .widget-two-thirds { flex: 2; }
            .widget-one-third { flex: 1; }
            
            .dashboard-card {
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 20px;
            }
            .card-header {
                margin-bottom: 15px;
                border-bottom: 1px solid var(--glass-border);
                padding-bottom: 10px;
            }
            .card-header h3 {
                font-size: 1.1rem;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--text-light);
            }

            /* Currency Styles */
            .currency-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }
            .currency-item {
                background: rgba(255,255,255,0.05);
                padding: 15px;
                border-radius: 8px;
                text-align: center;
            }
            .currency-code { font-weight: bold; color: var(--secondary-color); display: block; }
            .currency-value { font-size: 1.2rem; margin: 5px 0; font-weight: 600; }
            .text-green { color: #4CAF50; }
            .text-red { color: #F44336; }

            /* Weather Styles */
            .weather-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
            }
            .weather-item {
                text-align: center;
                background: rgba(255,255,255,0.05);
                padding: 10px;
                border-radius: 8px;
            }
            .weather-temp { font-size: 1.1rem; font-weight: bold; margin-top: 5px; }

            /* Feed Styles */
            .scrollable-feed {
                max-height: 400px;
                overflow-y: auto;
            }
            .activity-list {
                list-style: none;
                padding: 0;
            }
            .activity-item {
                display: flex;
                gap: 15px;
                padding: 10px 0;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .activity-icon {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                flex-shrink: 0;
            }
            .activity-content { flex: 1; }
            .activity-msg { font-size: 0.9rem; margin-bottom: 4px; }
            .activity-time { font-size: 0.75rem; color: var(--text-muted); }

            @media (max-width: 1024px) {
                .widget-row { flex-direction: column; }
                .currency-grid, .weather-grid { grid-template-columns: repeat(2, 1fr); }
            }

            /* Leaflet Info Control */
            .info {
                padding: 6px 8px;
                font: 14px/16px Arial, Helvetica, sans-serif;
                background: white;
                background: rgba(255,255,255,0.8);
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                border-radius: 5px;
                color: #333;
            }
            .info h4 {
                margin: 0 0 5px;
                color: #777;
            }
        </style>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="dashboard-card widget-half">
                <div class="card-header">
                    <h3><i class="ri-pie-chart-line"></i> Distribuição de Viagens</h3>
                </div>
                <div style="height: 300px; display: flex; justify-content: center;">
                    <canvas id="tripsChart"></canvas>
                </div>
            </div>
            
            <div class="dashboard-card widget-half">
                <div class="card-header">
                    <h3><i class="ri-fire-line"></i> Destinos em Alta</h3>
                </div>
                <div id="top-destinations" class="widget-content">
                    <!-- Populated by JS -->
                    <p>Carregando...</p>
                </div>
            </div>
        </div>

        <style>
            /* ... existing styles ... */
            .charts-grid {
                margin-top: 20px;
                display: flex;
                gap: 20px;
                margin-bottom: 30px;
            }
            
            @media (max-width: 768px) {
                .charts-grid { flex-direction: column; }
            }

            /* Top Destinations Styles */
            .destination-item {
                margin-bottom: 15px;
            }
            .destination-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
                font-size: 0.9rem;
            }
            .progress-bar-bg {
                background: rgba(255,255,255,0.1);
                height: 8px;
                border-radius: 4px;
                overflow: hidden;
            }
            .progress-bar-fill {
                height: 100%;
                background: var(--secondary-color);
                border-radius: 4px;
                transition: width 1s ease-in-out;
            }
        </style>

    </main>

    <script src="js/admin.js"></script>
</body>
</html>
