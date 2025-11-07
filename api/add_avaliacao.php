<?php
include '../config.php';
include '../db_connect.php';

// 1. GUARDIÃO: Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver, morre. (O formulário nem deveria aparecer, mas é uma segurança)
    die("Acesso não autorizado.");
}
$usuario_id = $_SESSION['user_id'];

// 2. Verifica se o método é POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: " . BASE_URL . "Avaliacoes/avaliacoes.php");
    exit;
}

// 3. Coleta e valida os dados
$viagem_id = $_POST['viagem_id'] ?? null;
$nota = $_POST['rating'] ?? null;
$mensagem = trim($_POST['message'] ?? '');

if (empty($viagem_id) || empty($nota) || empty($mensagem)) {
    // Se dados essenciais faltarem, redireciona com erro
    $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
    header("Location: " . BASE_URL . "Avaliacoes/avaliacoes.php");
    exit;
}

// 4. Prepara e insere no banco
try {
    $sql = "INSERT INTO avaliacoes (usuario_id, viagem_id, nota, mensagem) 
            VALUES (:usuario_id, :viagem_id, :nota, :mensagem)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':viagem_id' => $viagem_id,
        ':nota' => intval($nota),
        ':mensagem' => $mensagem
    ]);

    // 5. Redireciona de volta com sucesso
    $_SESSION['msg_sucesso'] = "Sua avaliação foi enviada com sucesso! Obrigado.";
    header("Location: " . BASE_URL . "Avaliacoes/avaliacoes.php");
    exit;

} catch (PDOException $e) {
    // Se der erro no banco
    error_log("Erro ao salvar avaliação: " . $e->getMessage());
    $_SESSION['msg_erro'] = "Houve um erro ao salvar sua avaliação. Tente novamente.";
    header("Location: " . BASE_URL . "Avaliacoes/avaliacoes.php");
    exit;
}
?>