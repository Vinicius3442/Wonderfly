<?php
include '../config.php';
include '../db_connect.php';

// 1. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

// 2. Pega os dados enviados pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$viagem_id = $data['viagem_id'] ?? null;
$user_id = $_SESSION['user_id'];

if (empty($viagem_id)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID da viagem não fornecido.']);
    exit;
}

try {
    // 3. Verifica se o favorito JÁ EXISTE
    $sql_check = "SELECT * FROM favoritos_viagens WHERE usuario_id = :user_id AND viagem_id = :viagem_id";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute(['user_id' => $user_id, 'viagem_id' => $viagem_id]);
    $existe = $stmt_check->fetch();

    if ($existe) {
        // 4. Se JÁ EXISTE, remove (DELETE)
        $sql_delete = "DELETE FROM favoritos_viagens WHERE usuario_id = :user_id AND viagem_id = :viagem_id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->execute(['user_id' => $user_id, 'viagem_id' => $viagem_id]);
        
        echo json_encode(['success' => true, 'action' => 'removed']);
        
    } else {
        // 5. Se NÃO EXISTE, adiciona (INSERT)
        $sql_insert = "INSERT INTO favoritos_viagens (usuario_id, viagem_id) VALUES (:user_id, :viagem_id)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->execute(['user_id' => $user_id, 'viagem_id' => $viagem_id]);
        
        echo json_encode(['success' => true, 'action' => 'added']);
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
}
?>