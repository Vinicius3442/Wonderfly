<?php
// 1. Inclui a configuração principal (sobe 1 nível)
// (Assume que o config.php inicia a sessão)
include_once '../config.php';

// 2. GUARDIÃO: Verifica se está logado E se é Admin
// (Lembrando que na sua tabela 'usuarios' temos a coluna 'is_admin')
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    
    // Se não for admin, chuta para a página de login
    $_SESSION['msg_erro'] = "Você não tem permissão para acessar esta área.";
    header("Location: " . BASE_URL . "Login/login.php");
    exit;
}

// 3. Se passou, inclui a conexão com o banco
include_once '../db_connect.php';

// (Guarda os dados do admin para usar no header)
$admin_id = $_SESSION['user_id'];
$admin_nome = $_SESSION['user_nome'];
?>