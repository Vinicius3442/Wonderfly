<?php
session_start();
define('ROOT_PATH', __DIR__ . '/');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$project_root_path = str_replace('\\', '/', __DIR__);
$base_path = str_replace($doc_root, '', $project_root_path);

define('BASE_URL', $protocol . '://' . $host . $base_path . '/');

/**
 * Cria o HTML das estrelas com base em uma nota.
 * @param int $nota - A nota de 1 a 5
 * @return string - O HTML com os ícones de estrela
 */
function generateStarsHTML($nota) {
    $stars = "";
    $notaNumerica = intval($nota); // Garante que é um número

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $notaNumerica) {
            // Estrela cheia
            $stars .= '<i class="fa-solid fa-star"></i> ';
        } else {
            // Estrela vazia (FontAwesome 6 usa 'regular')
            $stars .= '<i class="fa-regular fa-star"></i> ';
        }
    }
    return $stars;
}
function exibirMensagens() {
    $mensagem = '';
    
    // Verifica se há uma mensagem de erro
    if (isset($_SESSION['msg_erro'])) {
        $mensagem = '<div class="message error" style="padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px; font-weight: 500; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">' . htmlspecialchars($_SESSION['msg_erro']) . '</div>';
        // Limpa a mensagem da sessão
        unset($_SESSION['msg_erro']);
    }
    
    // Verifica se há uma mensagem de sucesso
    if (isset($_SESSION['msg_sucesso'])) {
        $mensagem = '<div class="message success" style="padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px; font-weight: 500; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">' . htmlspecialchars($_SESSION['msg_sucesso']) . '</div>';
        // Limpa a mensagem da sessão
        unset($_SESSION['msg_sucesso']);
    }
    
    echo $mensagem;
}
