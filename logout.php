<?php
// logout.php
// Código de logout em PHP

session_start();

// Limpa todas as variáveis de sessão
$_SESSION = [];

// Apaga o cookie de sessão (se existir)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Se você usa um cookie "remember me", apague também (ajuste o nome se necessário)
if (isset($_COOKIE['rememberme'])) {
    setcookie('rememberme', '', time() - 42000, '/');
}

// Destrói a sessão
session_destroy();

// Redireciona para a página de login ou home
header('Location: index.php');
exit;
?>