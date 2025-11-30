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
    <title>Detalhes do Usuário - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .profile-header {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-color);
        }
        .profile-info h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #fff;
        }
        .profile-info p {
            color: var(--text-muted);
            margin-bottom: 5px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
        .stat-box h3 {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 5px;
        }
        .stat-box p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .bio-box {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .bio-box h3 {
            margin-bottom: 15px;
            color: #fff;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 10px;
        }
        .bio-box p {
            line-height: 1.6;
            color: var(--text-light);
        }
        .btn-public {
            background: var(--secondary-color);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-public:hover {
            filter: brightness(1.1);
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
            <a href="users.php" class="nav-item active">
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
                <h1>Perfil Técnico</h1>
            </div>
            <div class="action-buttons">
                <button class="btn-export" onclick="history.back()">
                    <i class="ri-arrow-left-line"></i> Voltar
                </button>
            </div>
        </div>

        <div id="loading" style="text-align: center; padding: 50px;">Carregando...</div>

        <div id="profileContent" style="display: none;">
            <div class="profile-header">
                <img id="userAvatar" src="" alt="Avatar" class="profile-avatar">
                <div class="profile-info">
                    <h2 id="userName">Nome do Usuário</h2>
                    <p><i class="ri-mail-line"></i> <span id="userEmail">email@exemplo.com</span></p>
                    <p><i class="ri-calendar-line"></i> Membro desde <span id="userDate">01/01/2023</span></p>
                    <div style="margin-top: 15px;">
                        <span id="userType" class="badge badge-user">Usuário</span>
                        <a id="publicProfileLink" href="#" target="_blank" class="btn-public" style="margin-left: 10px;">
                            <i class="ri-external-link-line"></i> Ver Perfil Público
                        </a>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <h3 id="statReviews">0</h3>
                    <p>Avaliações Feitas</p>
                </div>
                <div class="stat-box">
                    <h3 id="statFavorites">0</h3>
                    <p>Viagens Favoritas</p>
                </div>
                <div class="stat-box">
                    <h3 id="statTopics">0</h3>
                    <p>Tópicos no Fórum</p>
                </div>
            </div>

            <div class="bio-box">
                <h3>Sobre</h3>
                <p id="userBio">Nenhuma biografia disponível.</p>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', fetchUserDetails);

        async function fetchUserDetails() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');

            if (!id) {
                alert('ID do usuário não fornecido.');
                window.location.href = 'users.php';
                return;
            }

            try {
                const response = await fetch(`api/get_user.php?id=${id}`);
                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    window.location.href = 'users.php';
                    return;
                }

                renderProfile(data);
            } catch (error) {
                console.error('Error fetching user:', error);
                alert('Erro ao carregar dados.');
            }
        }

        function fixImagePath(path) {
            if (!path) return '../images/profile/default.jpg';
            if (path.startsWith('http')) return path;
            
            // Remove ./ if present
            if (path.startsWith('./')) path = path.substring(2);
            // Remove / if present at start
            if (path.startsWith('/')) path = path.substring(1);
            
            // Prepend ../ to go back to root
            return '../' + path;
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
                    fetchUserDetails(); // Reload details
                } else {
                    alert('Erro: ' + result.error);
                }
            } catch (error) {
                console.error('Error moderating user:', error);
            }
        }

        function renderProfile(user) {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('profileContent').style.display = 'block';

            // Update header info
            document.getElementById('userName').innerHTML = `
                ${user.nome_exibicao} 
                ${user.is_banned == 1 ? '<span style="background:#ff4d4d;color:white;padding:2px 6px;border-radius:4px;font-size:0.8rem;vertical-align:middle;margin-left:5px;">BANIDO</span>' : ''}
            `;
            document.getElementById('userEmail').textContent = user.email;
            document.getElementById('userDate').textContent = new Date(user.data_criacao).toLocaleDateString('pt-BR');
            document.getElementById('userBio').textContent = user.bio || 'Nenhuma biografia disponível.';
            
            // Update avatar
            const avatarImg = document.getElementById('userAvatar');
            let avatar = user.avatar_url;
            if (!avatar) {
                avatar = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.nome_exibicao);
            } else {
                avatar = fixImagePath(avatar);
            }
            avatarImg.src = avatar;

            const typeBadge = document.getElementById('userType');
            typeBadge.textContent = user.tipo;
            typeBadge.className = `badge ${user.tipo === 'admin' ? 'badge-admin' : 'badge-user'}`;

            // Stats
            document.getElementById('statReviews').textContent = user.stats.reviews;
            document.getElementById('statFavorites').textContent = user.stats.favorites;
            document.getElementById('statTopics').textContent = user.stats.topics;

            // Public Profile Link
            // Assuming the path is ../perfil/perfil.php?id=ID based on directory structure
            document.getElementById('publicProfileLink').href = `../perfil/perfil.php?id=${user.id}`;
        }
    </script>
    
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-admin {
            background: rgba(240, 121, 19, 0.2);
            color: var(--accent-color);
        }
        .badge-user {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
        }
    </style>
</body>
</html>
