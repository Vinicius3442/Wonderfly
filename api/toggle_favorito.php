<?php
header('Content-Type: application/json');
require_once '../config.php';
require_once '../db_connect.php';



// 1. Verifica login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

// 2. Verifica método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// 3. Pega o corpo da requisição (JSON)
$input = json_decode(file_get_contents('php://input'), true);
$viagem_id = $input['viagem_id'] ?? null;

if (!$viagem_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID da viagem não fornecido']);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // 4. Verifica se já é favorito
    // Seleciona 1 em vez de id, pois a tabela pode não ter chave primária id (apenas composta)
    $stmt = $conn->prepare("SELECT 1 FROM favoritos_viagens WHERE usuario_id = ? AND viagem_id = ?");
    $stmt->execute([$user_id, $viagem_id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // REMOVE
        $stmt = $conn->prepare("DELETE FROM favoritos_viagens WHERE usuario_id = ? AND viagem_id = ?");
        $stmt->execute([$user_id, $viagem_id]);
        $action = 'removed';
    } else {
        // ADICIONA
        $stmt = $conn->prepare("INSERT INTO favoritos_viagens (usuario_id, viagem_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $viagem_id]);
        $action = 'added';
    }

    echo json_encode(['success' => true, 'action' => $action]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>