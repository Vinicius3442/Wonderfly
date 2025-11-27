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
        $type = $_GET['type'] ?? 'all';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $offset = ($page - 1) * $limit;

        $response = [];

        // Fetch Topics
        if ($type === 'all' || $type === 'topics') {
            // Count
            $countStmt = $conn->query("SELECT COUNT(*) FROM topicos");
            $total_topics = $countStmt->fetchColumn();
            
            // Data
            $stmtTopics = $conn->prepare("
                SELECT t.id, t.assunto, t.mensagem, t.data_criacao, u.nome_exibicao, u.id as usuario_id, u.is_banned
                FROM topicos t
                LEFT JOIN usuarios u ON t.usuario_id = u.id
                ORDER BY t.data_criacao DESC
                LIMIT :limit OFFSET :offset
            ");
            $stmtTopics->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmtTopics->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmtTopics->execute();
            
            $topics_data = $stmtTopics->fetchAll(PDO::FETCH_ASSOC);
            
            if ($type === 'topics') {
                $response = [
                    'data' => $topics_data,
                    'pagination' => [
                        'current_page' => $page,
                        'total_pages' => ceil($total_topics / $limit),
                        'total_items' => $total_topics,
                        'limit' => $limit
                    ]
                ];
            } else {
                $response['topics'] = $topics_data;
            }
        }

        // Fetch Replies
        if ($type === 'all' || $type === 'replies') {
            // Count
            $countStmt = $conn->query("SELECT COUNT(*) FROM respostas");
            $total_replies = $countStmt->fetchColumn();

            // Data
            $stmtReplies = $conn->prepare("
                SELECT r.id, r.mensagem, r.data_criacao, r.topico_id, u.nome_exibicao, u.id as usuario_id, u.is_banned
                FROM respostas r
                LEFT JOIN usuarios u ON r.usuario_id = u.id
                ORDER BY r.data_criacao DESC
                LIMIT :limit OFFSET :offset
            ");
            $stmtReplies->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmtReplies->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmtReplies->execute();
            
            $replies_data = $stmtReplies->fetchAll(PDO::FETCH_ASSOC);

            if ($type === 'replies') {
                $response = [
                    'data' => $replies_data,
                    'pagination' => [
                        'current_page' => $page,
                        'total_pages' => ceil($total_replies / $limit),
                        'total_items' => $total_replies,
                        'limit' => $limit
                    ]
                ];
            } else {
                $response['replies'] = $replies_data;
            }
        }

        echo json_encode($response);

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
