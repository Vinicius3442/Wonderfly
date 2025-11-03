<?php
include '../config.php';
include '../db_connect.php';

header('Content-Type: application/json');

// 1. GUARDIÃO: Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}
$user_id = $_SESSION['user_id'];

// 2. Pega o ID do tópico enviado pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$topico_id = $data['id'] ?? null;

if (empty($topico_id)) {
    echo json_encode(['success' => false, 'message' => 'ID do tópico não fornecido.']);
    exit;
}

try {
    // 3. SEGURANÇA: Deleta o tópico SOMENTE SE o ID do tópico
    //    corresponder E o ID do autor for o do usuário logado.
    
    // (O 'ON DELETE CASCADE' que definimos no banco vai cuidar de 
    // apagar todas as 'respostas' ligadas a este tópico automaticamente)
    
    $sql = "DELETE FROM topicos WHERE id = :topico_id AND usuario_id = :user_id";
    $stmt = $conn->prepare($sql);
    
    $stmt->execute([
        ':topico_id' => $topico_id,
        ':user_id' => $user_id
    ]);

    // 4. Verifica se algo foi realmente apagado
    // rowCount() diz quantas linhas foram afetadas.
    if ($stmt->rowCount() > 0) {
        // Sucesso: 1 linha (o tópico) foi apagada
        echo json_encode(['success' => true, 'message' => 'Tópico apagado.']);
    } else {
        // Falha: 0 linhas foram apagadas (ou o tópico não existe, ou não pertence a este usuário)
        throw new Exception('Você não tem permissão para apagar este tópico ou ele não existe.');
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>