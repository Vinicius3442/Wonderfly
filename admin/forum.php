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
    <title>Moderação do Fórum - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/forum-style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .moderation-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .moderation-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .moderation-card.flagged {
            border-color: #ff4d4d;
            background: rgba(255, 77, 77, 0.1);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .card-content {
            margin-bottom: 15px;
            color: var(--text-light);
        }
        .card-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .offensive-word {
            background-color: rgba(255, 0, 0, 0.3);
            color: #fff;
            padding: 0 4px;
            border-radius: 4px;
        }
        .banned-badge {
            background: #ff4d4d;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
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
            <a href="forum.php" class="nav-item active">
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
                <h1>Moderação do Fórum</h1>
            </div>
            <div class="user-profile">
                <span id="admin-name">Admin</span>
                <img id="admin-avatar" src="" alt="Admin" class="user-avatar">
            </div>
            </div>
        </div>

        <script src="js/avatar.js"></script>
        </div>

        <div class="moderation-grid">
            <!-- Topics Column -->
            <div class="moderation-column">
                <h2>Tópicos Recentes</h2>
                <div id="topicsList">
                    <p>Carregando...</p>
                </div>
                <!-- Topics Pagination -->
                <div class="pagination-controls small-controls">
                    <button id="prevPageTopics" disabled><i class="ri-arrow-left-s-line"></i></button>
                    <span id="currentPageTopics">1</span>
                    <button id="nextPageTopics" disabled><i class="ri-arrow-right-s-line"></i></button>
                </div>
            </div>

            <!-- Replies Column -->
            <div class="moderation-column">
                <h2>Respostas Recentes</h2>
                <div id="repliesList">
                    <p>Carregando...</p>
                </div>
                <!-- Replies Pagination -->
                <div class="pagination-controls small-controls">
                    <button id="prevPageReplies" disabled><i class="ri-arrow-left-s-line"></i></button>
                    <span id="currentPageReplies">1</span>
                    <button id="nextPageReplies" disabled><i class="ri-arrow-right-s-line"></i></button>
                </div>
            </div>
        </div>

    </main>

    <script>
        // Simple list of offensive words for demonstration
        const offensiveWords = ['palavrão', 'idiota', 'burro', 'estúpido', 'imbecil', 'merda', 'porra', 'caralho'];

        let pageTopics = 1;
        let pageReplies = 1;
        const limit = 10;

        document.addEventListener('DOMContentLoaded', () => {
            fetchTopics();
            fetchReplies();
            setupPaginationListeners();
        });

        function setupPaginationListeners() {
            // Topics
            document.getElementById('prevPageTopics').addEventListener('click', () => {
                if (pageTopics > 1) {
                    pageTopics--;
                    fetchTopics();
                }
            });
            document.getElementById('nextPageTopics').addEventListener('click', () => {
                pageTopics++;
                fetchTopics();
            });

            // Replies
            document.getElementById('prevPageReplies').addEventListener('click', () => {
                if (pageReplies > 1) {
                    pageReplies--;
                    fetchReplies();
                }
            });
            document.getElementById('nextPageReplies').addEventListener('click', () => {
                pageReplies++;
                fetchReplies();
            });
        }

        async function fetchTopics() {
            try {
                const response = await fetch(`api/forum.php?type=topics&page=${pageTopics}&limit=${limit}`);
                const result = await response.json();
                
                renderTopics(result.data);
                updatePaginationUI('Topics', result.pagination);
            } catch (error) {
                console.error('Error fetching topics:', error);
            }
        }

        async function fetchReplies() {
            try {
                const response = await fetch(`api/forum.php?type=replies&page=${pageReplies}&limit=${limit}`);
                const result = await response.json();
                
                renderReplies(result.data);
                updatePaginationUI('Replies', result.pagination);
            } catch (error) {
                console.error('Error fetching replies:', error);
            }
        }

        function updatePaginationUI(type, pagination) {
            document.getElementById(`currentPage${type}`).textContent = pagination.current_page;
            document.getElementById(`prevPage${type}`).disabled = pagination.current_page <= 1;
            document.getElementById(`nextPage${type}`).disabled = pagination.current_page >= pagination.total_pages;
        }

        function highlightOffensive(text) {
            let html = text;
            let isFlagged = false;
            offensiveWords.forEach(word => {
                const regex = new RegExp(`\\b${word}\\b`, 'gi');
                if (regex.test(text)) {
                    isFlagged = true;
                    html = html.replace(regex, `<span class="offensive-word">$&</span>`);
                }
            });
            return { html, isFlagged };
        }

        function renderTopics(topics) {
            const container = document.getElementById('topicsList');
            container.innerHTML = '';
            
            if (topics.length === 0) {
                container.innerHTML = '<p>Nenhum tópico encontrado.</p>';
                return;
            }

            topics.forEach(topic => {
                const { html: subjectHtml, isFlagged: subjectFlagged } = highlightOffensive(topic.assunto);
                const { html: msgHtml, isFlagged: msgFlagged } = highlightOffensive(topic.mensagem);
                const isFlagged = subjectFlagged || msgFlagged;

                const div = document.createElement('div');
                div.className = `moderation-card ${isFlagged ? 'flagged' : ''}`;
                div.innerHTML = `
                    <div class="card-header">
                        <span>
                            <i class="ri-user-line"></i> ${topic.nome_exibicao}
                            ${topic.is_banned == 1 ? '<span class="banned-badge">BANIDO</span>' : ''}
                        </span>
                        <span>${new Date(topic.data_criacao).toLocaleDateString('pt-BR')}</span>
                    </div>
                    <div class="card-content">
                        <strong>${subjectHtml}</strong>
                        <p>${msgHtml}</p>
                    </div>
                    <div class="card-actions">
                        ${topic.is_banned == 0 ? `
                        <button class="btn-icon delete" onclick="banUser(${topic.usuario_id})" title="Banir Usuário">
                            <i class="ri-prohibited-line"></i>
                        </button>` : `
                        <button class="btn-icon" onclick="unbanUser(${topic.usuario_id})" title="Desbanir Usuário" style="color: #4CAF50;">
                            <i class="ri-checkbox-circle-line"></i>
                        </button>`}
                        
                        <button class="btn-icon delete" onclick="deleteContent('topic', ${topic.id})" title="Excluir Tópico">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        function renderReplies(replies) {
            const container = document.getElementById('repliesList');
            container.innerHTML = '';

            if (replies.length === 0) {
                container.innerHTML = '<p>Nenhuma resposta encontrada.</p>';
                return;
            }

            replies.forEach(reply => {
                const { html, isFlagged } = highlightOffensive(reply.mensagem);

                const div = document.createElement('div');
                div.className = `moderation-card ${isFlagged ? 'flagged' : ''}`;
                div.innerHTML = `
                    <div class="card-header">
                        <span>
                            <i class="ri-user-line"></i> ${reply.nome_exibicao}
                            ${reply.is_banned == 1 ? '<span class="banned-badge">BANIDO</span>' : ''}
                        </span>
                        <span>${new Date(reply.data_criacao).toLocaleDateString('pt-BR')}</span>
                    </div>
                    <div class="card-content">
                        <p>${html}</p>
                    </div>
                    <div class="card-actions">
                        ${reply.is_banned == 0 ? `
                        <button class="btn-icon delete" onclick="banUser(${reply.usuario_id})" title="Banir Usuário">
                            <i class="ri-prohibited-line"></i>
                        </button>` : `
                        <button class="btn-icon" onclick="unbanUser(${reply.usuario_id})" title="Desbanir Usuário" style="color: #4CAF50;">
                            <i class="ri-checkbox-circle-line"></i>
                        </button>`}

                        <button class="btn-icon delete" onclick="deleteContent('reply', ${reply.id})" title="Excluir Resposta">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        async function deleteContent(type, id) {
            if (!confirm('Tem certeza que deseja excluir este conteúdo?')) return;

            try {
                const response = await fetch('api/forum.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ type, id })
                });
                const result = await response.json();
                if (result.success) {
                    fetchForumContent();
                } else {
                    alert('Erro ao excluir: ' + result.error);
                }
            } catch (error) {
                console.error('Error deleting:', error);
            }
        }

        async function banUser(userId) {
            if (!confirm('Tem certeza que deseja BANIR este usuário?')) return;
            toggleBan(userId, 'ban');
        }

        async function unbanUser(userId) {
            if (!confirm('Tem certeza que deseja DESBANIR este usuário?')) return;
            toggleBan(userId, 'unban');
        }

        async function toggleBan(userId, action) {
            try {
                const response = await fetch('api/moderate_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: userId, action })
                });
                const result = await response.json();
                if (result.success) {
                    fetchForumContent();
                } else {
                    alert('Erro: ' + result.error);
                }
            } catch (error) {
                console.error('Error moderating user:', error);
            }
        }
    </script>
</body>
</html>
