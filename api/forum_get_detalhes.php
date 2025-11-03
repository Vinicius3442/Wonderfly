<?php
include '../config.php';
include '../db_connect.php';
header('Content-Type: application/json');

$topico_id = $_GET['id'] ?? null;

if (empty($topico_id)) {
    echo json_encode(['success' => false, 'message' => 'ID do tópico não fornecido.']);
    exit;
}

try {
    $response = ['success' => true];

    // 1. Busca o Tópico Original e o Autor
    $sql_op = "
        SELECT t.*, u.nome_exibicao AS autor_nome, u.avatar_url AS autor_avatar
        FROM topicos AS t
        LEFT JOIN usuarios AS u ON t.usuario_id = u.id
        WHERE t.id = :id
    ";
    $stmt_op = $conn->prepare($sql_op);
    $stmt_op->execute(['id' => $topico_id]);
    $response['topico'] = $stmt_op->fetch(PDO::FETCH_ASSOC);

    if (!$response['topico']) {
        echo json_encode(['success' => false, 'message' => 'Tópico não encontrado.']);
        exit;
    }

    // 2. Busca as Respostas e seus Autores
    $sql_rep = "
        SELECT r.*, u.nome_exibicao AS autor_nome, u.avatar_url AS autor_avatar
        FROM respostas AS r
        LEFT JOIN usuarios AS u ON r.usuario_id = u.id
        WHERE r.topico_id = :id
        ORDER BY r.data_criacao ASC
    ";
    $stmt_rep = $conn->prepare($sql_rep);
    $stmt_rep->execute(['id' => $topico_id]);
    $response['respostas'] = $stmt_rep->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
}
?>