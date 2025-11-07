<?php
// 1. Inclui o config (que inicia a sessão) e o banco
include '../config.php';
include '../db_connect.php';

header('Content-Type: application/json');

// 2. GUARDIÃO DE ADMIN (Manual)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}

// 3. Pega o ID da viagem enviado pelo JavaScript (fetch)
$data = json_decode(file_get_contents('php://input'), true);
$viagem_id = $data['id'] ?? null;

if (empty($viagem_id)) {
    echo json_encode(['success' => false, 'message' => 'ID da viagem não fornecido.']);
    exit;
}

try {
    // 4. Deleta a viagem
    // (O 'ON DELETE CASCADE' ou 'SET NULL' nas outras tabelas
    // cuidará de apagar/limpar os dados relacionados)
    
    $sql = "DELETE FROM viagens WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $viagem_id]);

    // 5. Verifica se algo foi realmente apagado
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Viagem excluída.']);
    } else {
        throw new Exception('Viagem não encontrada.');
    }

} catch (PDOException $e) {
    // Captura erros de chave estrangeira, etc.
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>