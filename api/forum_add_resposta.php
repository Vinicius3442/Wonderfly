<?php
include '../config.php';
include '../db_connect.php';
header('Content-Type: application/json');

// 1. GUARDIÃO: Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}
$user_id = $_SESSION['user_id'];

// 2. Pega os dados
$data = json_decode(file_get_contents('php://input'), true);
$topico_id = $data['topico_id'] ?? null;
$message = trim($data['message'] ?? '');

if (empty($topico_id) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

try {
    // 3. Insere no Banco
    $sql = "INSERT INTO respostas (topico_id, usuario_id, mensagem) 
            VALUES (:topico_id, :user_id, :message)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'topico_id' => $topico_id,
        'user_id' => $user_id,
        'message' => $message
    ]);

    // 4. Devolve a nova resposta formatada
    $new_id = $conn->lastInsertId();
    $nova_resposta = [
        'id' => $new_id,
        'mensagem' => $message,
        'data_criacao' => date('Y-m-d H:i:s'),
        'autor_nome' => $_SESSION['user_nome'],
        'autor_avatar' => '' // (TODO: buscar avatar do usuário da sessão)
    ];

    echo json_encode(['success' => true, 'resposta' => $nova_resposta]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
?>