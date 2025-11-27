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
    <title>Usuários - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- jsPDF for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../assets/img/logo.png" alt="WonderFly Logo" style="height: 40px; margin-right: 10px;">
            <span>WonderFly</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            <a href="blog.php" class="nav-item">
                <i class="ri-article-line"></i> Blog
            </a>
            <a href="#" class="nav-item">
                <i class="ri-discuss-line"></i> Fórum
            </a>
            <a href="users.php" class="nav-item active">
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
                <h1>Gerenciar Usuários</h1>
            </div>
            <div class="user-profile">
                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <img src="<?php echo htmlspecialchars($_SESSION['user_avatar']); ?>" alt="Avatar" class="user-avatar">
            </div>
        </div>

        <!-- Actions Bar -->
        <div class="actions-bar">
            <div class="search-box">
                <i class="ri-search-line"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nome ou email...">
            </div>
            <div class="action-buttons">
                <button class="btn-export" onclick="exportToCSV()">
                    <i class="ri-file-excel-line"></i> CSV
                </button>
                <button class="btn-export" onclick="exportToPDF()">
                    <i class="ri-file-pdf-line"></i> PDF
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Data Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <!-- Rows will be populated by JS -->
                </tbody>
            </table>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', fetchUsers);

        let allUsers = [];

        async function fetchUsers() {
            try {
                const response = await fetch('api/users.php');
                const data = await response.json();
                
                if (data.error) {
                    alert(data.error);
                    return;
                }

                allUsers = data;
                renderTable(allUsers);
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        }

        function renderTable(users) {
            const tbody = document.getElementById('usersTableBody');
            tbody.innerHTML = '';

            users.forEach(user => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>#${user.id}</td>
                    <td class="fw-bold">${user.nome}</td>
                    <td>${user.email}</td>
                    <td><span class="badge ${user.tipo === 'admin' ? 'badge-admin' : 'badge-user'}">${user.tipo}</span></td>
                    <td>${new Date(user.data_criacao).toLocaleDateString('pt-BR')}</td>
                    <td class="actions-cell">
                        <a href="user_details.php?id=${user.id}" class="btn-icon" title="Ver Detalhes">
                            <i class="ri-eye-line"></i>
                        </a>
                        <button class="btn-icon delete" onclick="deleteUser(${user.id})" title="Excluir">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Search Filter
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = allUsers.filter(user => 
                user.nome.toLowerCase().includes(term) || 
                user.email.toLowerCase().includes(term)
            );
            renderTable(filtered);
        });

        async function deleteUser(id) {
            if (!confirm('Tem certeza que deseja excluir este usuário?')) return;

            try {
                const response = await fetch('api/users.php', {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                });
                const result = await response.json();

                if (result.success) {
                    fetchUsers();
                } else {
                    alert('Erro ao excluir: ' + result.error);
                }
            } catch (error) {
                console.error('Error deleting:', error);
            }
        }

        // Export Functions
        function exportToCSV() {
            let csvContent = "data:text/csv;charset=utf-8,ID,Nome,Email,Tipo,Data Criação\n";
            allUsers.forEach(user => {
                csvContent += `${user.id},"${user.nome}","${user.email}",${user.tipo},${user.data_criacao}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "usuarios_wonderfly.csv");
            document.body.appendChild(link);
            link.click();
        }

        function exportToPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            
            doc.text("Relatório de Usuários - WonderFly", 14, 15);
            
            const tableColumn = ["ID", "Nome", "Email", "Tipo", "Data Criação"];
            const tableRows = [];

            allUsers.forEach(user => {
                const userData = [
                    user.id,
                    user.nome,
                    user.email,
                    user.tipo,
                    new Date(user.data_criacao).toLocaleDateString('pt-BR')
                ];
                tableRows.push(userData);
            });

            doc.autoTable({
                head: [tableColumn],
                body: tableRows,
                startY: 20,
            });

            doc.save("usuarios_wonderfly.pdf");
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
