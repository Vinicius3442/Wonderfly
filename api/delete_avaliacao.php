<?php
include '../config.php';
include '../db_connect.php';

header('Content-Type: application/json');

// 1. GUARDIÃO: Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}
$usuario_id_logado = $_SESSION['user_id'];

// 2. Pega o ID da avaliação enviado pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$avaliacao_id = $data['id'] ?? null;

if (empty($avaliacao_id)) {
    echo json_encode(['success' => false, 'message' => 'ID da avaliação não fornecido.']);
    exit;
}

try {
    // 3. SEGURANÇA: Deleta a avaliação SOMENTE SE o ID
    //    corresponder E o usuario_id for o do usuário logado.
    $sql = "DELETE FROM avaliacoes 
            WHERE id = :avaliacao_id AND usuario_id = :usuario_id_logado";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':avaliacao_id' => $avaliacao_id,
        ':usuario_id_logado' => $usuario_id_logado
    ]);

    // 4. Verifica se algo foi realmente apagado
    if ($stmt->rowCount() > 0) {
        // Sucesso: 1 linha foi apagada
        echo json_encode(['success' => true, 'message' => 'Avaliação excluída.']);
    } else {
        // Falha: 0 linhas (ou a avaliação não existe, ou não pertence ao usuário)
        throw new Exception('Você não tem permissão para excluir esta avaliação.');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>