<?php
include '../config.php';
include '../db_connect.php';
header('Content-Type: application/json');

// 1. GUARDIÃO DE ADMIN
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}

// 2. Pega o ID
$data = json_decode(file_get_contents('php://input'), true);
$artigo_id = $data['id'] ?? null;

if (empty($artigo_id)) {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
    exit;
}

try {
    // 3. Deleta o artigo
    // (O 'ON DELETE CASCADE' na tabela 'artigo_tags' limpa as tags automaticamente)
    $sql = "DELETE FROM artigos_blog WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $artigo_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Artigo excluído.']);
    } else {
        throw new Exception('Artigo não encontrado.');
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>