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
    <title>Moderação de Avaliações - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .review-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .review-meta {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .star-rating {
            color: #FFD700;
        }
        .review-trip {
            font-weight: 600;
            color: var(--secondary-color);
        }
    </style>
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
            <a href="trips.php" class="nav-item">
                <i class="ri-map-pin-line"></i> Viagens
            </a>
            <a href="reviews.php" class="nav-item active">
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
                <h1>Moderação de Avaliações</h1>
            </div>
            <div class="user-profile">
                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <img src="<?php echo str_replace('./', '../', htmlspecialchars($_SESSION['user_avatar'])); ?>" alt="Avatar" class="user-avatar">
            </div>
        </div>

        <!-- Sorting Controls -->
        <div class="actions-bar" style="margin-bottom: 20px;">
            <div class="search-box">
                <label for="sortSelect" style="margin-right: 10px;">Ordenar por:</label>
                <select id="sortSelect" onchange="changeSort()">
                    <option value="data_criacao">Data</option>
                    <option value="nota">Nota</option>
                </select>
                <button id="orderBtn" class="btn-icon" onclick="toggleOrder()" title="Inverter Ordem" style="margin-left: 10px;">
                    <i class="ri-arrow-down-line" id="orderIcon"></i>
                </button>
            </div>
        </div>

        <div id="reviewsList">
            <p>Carregando...</p>
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
                <select id="limitSelect" onchange="changeLimit()">
                    <option value="10">10 por página</option>
                    <option value="20">20 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>
        </div>

    </main>

    <script>
        let currentPage = 1;
        let limit = 10;
        let sort = 'data_criacao';
        let order = 'DESC';

        document.addEventListener('DOMContentLoaded', () => {
            fetchReviews();
            setupPaginationListeners();
        });

        function setupPaginationListeners() {
            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchReviews();
                }
            });
            document.getElementById('nextPage').addEventListener('click', () => {
                currentPage++;
                fetchReviews();
            });
        }

        function changeSort() {
            sort = document.getElementById('sortSelect').value;
            currentPage = 1;
            fetchReviews();
        }

        function toggleOrder() {
            order = order === 'ASC' ? 'DESC' : 'ASC';
            const icon = document.getElementById('orderIcon');
            icon.className = order === 'ASC' ? 'ri-arrow-up-line' : 'ri-arrow-down-line';
            fetchReviews();
        }

        function changeLimit() {
            limit = parseInt(document.getElementById('limitSelect').value);
            currentPage = 1;
            fetchReviews();
        }

        async function fetchReviews() {
            try {
                const response = await fetch(`api/reviews.php?page=${currentPage}&limit=${limit}&sort=${sort}&order=${order}`);
                const result = await response.json();
                
                if (result.error) {
                    alert(result.error);
                    return;
                }

                renderReviews(result.data);
                updatePaginationUI(result.pagination);

            } catch (error) {
                console.error('Error fetching reviews:', error);
            }
        }

        function updatePaginationUI(pagination) {
            document.getElementById('currentPage').textContent = pagination.current_page;
            document.getElementById('totalItems').textContent = pagination.total_items;
            
            const start = (pagination.current_page - 1) * pagination.limit + 1;
            const end = Math.min(start + pagination.limit - 1, pagination.total_items);
            
            document.getElementById('startItem').textContent = pagination.total_items > 0 ? start : 0;
            document.getElementById('endItem').textContent = end;

            document.getElementById('prevPage').disabled = pagination.current_page <= 1;
            document.getElementById('nextPage').disabled = pagination.current_page >= pagination.total_pages;
        }

        function renderReviews(reviews) {
            const container = document.getElementById('reviewsList');
            container.innerHTML = '';

            if (reviews.length === 0) {
                container.innerHTML = '<p>Nenhuma avaliação encontrada.</p>';
                return;
            }

            reviews.forEach(review => {
                const stars = '★'.repeat(review.nota) + '☆'.repeat(5 - review.nota);
                
                const div = document.createElement('div');
                div.className = 'review-card';
                div.innerHTML = `
                    <div class="review-header">
                        <span class="review-trip"><i class="ri-map-pin-line"></i> ${review.viagem_titulo}</span>
                        <div class="star-rating">${stars}</div>
                    </div>
                    <div class="review-meta">
                        <i class="ri-user-line"></i> ${review.nome_exibicao} • 
                        ${new Date(review.data_criacao).toLocaleDateString('pt-BR')}
                    </div>
                    <p>"${review.mensagem}"</p>
                    <div style="text-align: right;">
                        <button class="btn-icon delete" onclick="deleteReview(${review.id})" title="Excluir Avaliação">
                            <i class="ri-delete-bin-line"></i> Excluir
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        async function deleteReview(id) {
            if (!confirm('Tem certeza que deseja excluir esta avaliação?')) return;

            try {
                const response = await fetch('api/reviews.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                });
                const result = await response.json();
                if (result.success) {
                    fetchReviews();
                } else {
                    alert('Erro ao excluir: ' + result.error);
                }
            } catch (error) {
                console.error('Error deleting:', error);
            }
        }
    </script>
</body>
</html>
