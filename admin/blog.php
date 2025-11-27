<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Blog - WonderFly Admin</title>
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
            <a href="#" class="nav-item active">
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
                <h1>Gerenciar Blog</h1>
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
                <input type="text" id="searchInput" placeholder="Buscar artigos...">
            </div>
            <div class="action-buttons">
                <button class="btn-export" onclick="exportCSV()">
                    <i class="ri-file-excel-line"></i> CSV
                </button>
                <button class="btn-export" onclick="exportPDF()">
                    <i class="ri-file-pdf-line"></i> PDF
                </button>
                <a href="blog_editor.php" class="btn-add">
                    <i class="ri-add-line"></i> Novo Artigo
                </a>
            </div>
        </div>

        <!-- Sorting Controls -->
        <div class="actions-bar" style="margin-bottom: 20px;">
            <div class="search-box">
                <label for="sortSelect" style="margin-right: 10px;">Ordenar por:</label>
                <select id="sortSelect" onchange="changeSort()">
                    <option value="data_publicacao">Data</option>
                    <option value="titulo">Título</option>
                </select>
                <button id="orderBtn" class="btn-icon" onclick="toggleOrder()" title="Inverter Ordem" style="margin-left: 10px;">
                    <i class="ri-arrow-down-line" id="orderIcon"></i>
                </button>
            </div>
        </div>

        <!-- Blog Grid -->
        <div id="blogGrid" class="blog-grid">
            <!-- Cards will be populated by JS -->
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <div class="page-info">
                Mostrando <span id="startItem">0</span> - <span id="endItem">0</span> de <span id="totalItems">0</span>
            </div>
            <div class="page-buttons">
                <button id="prevPage" disabled><i class="ri-arrow-left-s-line"></i> Anterior</button>
                <span id="currentPage">1</span>
                <button id="nextPage" disabled>Próximo <i class="ri-arrow-right-s-line"></i></button>
            </div>
            <div class="limit-selector">
                <select id="limitSelect">
                    <option value="10">10 por página</option>
                    <option value="20">20 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>
        </div>

    </main>

    <script src="js/blog.js"></script>
</body>
</html>
