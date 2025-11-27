<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Viagens - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Libraries for Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../images/logo.png" alt="WonderFly Logo" style="height: 40px; margin-right: 10px;">
            <span>WonderFly</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
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
            <a href="trips.php" class="nav-item active">
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
                <h1>Gerenciar Viagens</h1>
            </div>
            <div class="user-profile">
                <span id="admin-name">Admin</span>
                <img id="admin-avatar" src="" alt="Admin" class="user-avatar">
            </div>
        </div>

        <!-- Actions Bar -->
        <div class="actions-bar">
            <div class="search-box">
                <i class="ri-search-line"></i>
                <input type="text" id="searchInput" placeholder="Buscar viagens...">
            </div>
            <div class="action-buttons">
                <button class="btn-export" onclick="exportCSV()">
                    <i class="ri-file-excel-line"></i> CSV
                </button>
                <button class="btn-export" onclick="exportPDF()">
                    <i class="ri-file-pdf-line"></i> PDF
                </button>
                <a href="trip_editor.php" class="btn-add">
                    <i class="ri-add-line"></i> Nova Viagem
                </a>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <table id="tripsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Continente</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tripsTableBody">
                    <!-- Rows will be populated by JS -->
                </tbody>
            </table>
        </div>

    </main>

    <script src="js/trips.js"></script>
</body>
</html>
