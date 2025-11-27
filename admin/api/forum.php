<?php
header('Content-Type: application/json');
require_once '../../db_connect.php';

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        // Fetch recent topics
        $stmtTopics = $conn->query("
            SELECT t.id, t.assunto, t.mensagem, t.data_criacao, u.nome_exibicao, u.id as usuario_id, u.is_banned
            FROM topicos t
            LEFT JOIN usuarios u ON t.usuario_id = u.id
            ORDER BY t.data_criacao DESC
            LIMIT 50
        ");
        $topics = $stmtTopics->fetchAll(PDO::FETCH_ASSOC);

        // Fetch recent replies
        $stmtReplies = $conn->query("
            SELECT r.id, r.mensagem, r.data_criacao, r.topico_id, u.nome_exibicao, u.id as usuario_id, u.is_banned
            FROM respostas r
            LEFT JOIN usuarios u ON r.usuario_id = u.id
            ORDER BY r.data_criacao DESC
            LIMIT 50
        ");
        $replies = $stmtReplies->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['topics' => $topics, 'replies' => $replies]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} elseif ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $type = $input['type'] ?? null; // 'topic' or 'reply'
    $id = $input['id'] ?? null;

    if (!$type || !$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }

    try {
        if ($type === 'topic') {
            $stmt = $conn->prepare("DELETE FROM topicos WHERE id = ?");
        } else {
            $stmt = $conn->prepare("DELETE FROM respostas WHERE id = ?");
        }
        $stmt->execute([$id]);

        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
