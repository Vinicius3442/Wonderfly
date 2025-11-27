<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <a href="#" class="nav-item">
                <i class="ri-discuss-line"></i> Fórum
            </a>
            <a href="users.php" class="nav-item">
                <i class="ri-user-line"></i> Usuários
            </a>
            <a href="trips.php" class="nav-item">
                <i class="ri-map-pin-line"></i> Viagens
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
                <div class="stat-icon">
                    <i class="ri-plane-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-trips">-</h3>
                    <p>Viagens Ativas</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ri-article-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-posts">-</h3>
                    <p>Artigos no Blog</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="ri-discuss-line"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-topics">-</h3>
                    <p>Tópicos no Fórum</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-header">Distribuição de Viagens</div>
                <canvas id="tripsChart"></canvas>
            </div>
            <!-- Placeholder for another chart or widget -->
            <div class="chart-container">
                <div class="chart-header">Atividade Recente</div>
                <p style="color: var(--text-muted);">Em breve...</p>
            </div>
        </div>

    </main>

    <script src="js/admin.js"></script>
</body>
</html>
