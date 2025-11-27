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
        // Pagination & Sorting Parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'data_criacao';
        $order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

        // Validate Sort Column
        $allowed_sorts = ['id', 'nota', 'data_criacao'];
        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'data_criacao';
        }

        $offset = ($page - 1) * $limit;

        // 1. Get Total Count
        $countStmt = $conn->query("SELECT COUNT(*) FROM avaliacoes");
        $total_items = $countStmt->fetchColumn();
        $total_pages = ceil($total_items / $limit);

        // 2. Get Data
        $sql = "
            SELECT a.id, a.nota, a.mensagem, a.data_criacao, u.nome_exibicao, v.titulo as viagem_titulo
            FROM avaliacoes a
            LEFT JOIN usuarios u ON a.usuario_id = u.id
            LEFT JOIN viagens v ON a.viagem_id = v.id
            ORDER BY a.$sort $order 
            LIMIT :limit OFFSET :offset
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'data' => $reviews,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total_items,
                'limit' => $limit
            ]
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} elseif ($method === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing ID']);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM avaliacoes WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
