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

        // Validate Sort Column (Security)
        $allowed_sorts = ['id', 'nome_exibicao', 'email', 'data_criacao', 'is_admin'];
        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'data_criacao';
        }

        $offset = ($page - 1) * $limit;

        // 1. Get Total Count
        $countStmt = $conn->query("SELECT COUNT(*) FROM usuarios");
        $total_items = $countStmt->fetchColumn();
        $total_pages = ceil($total_items / $limit);

        // 2. Get Data
        $sql = "SELECT id, nome_exibicao, email, is_admin, is_banned, data_criacao 
                FROM usuarios 
                ORDER BY $sort $order 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $result_data = array_map(function($user) {
            $user['tipo'] = $user['is_admin'] ? 'admin' : 'usuario';
            return $user;
        }, $users);

        echo json_encode([
            'data' => $result_data,
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

    // Prevent deleting self
    if ($id == $_SESSION['user_id']) {
        http_response_code(400);
        echo json_encode(['error' => 'Cannot delete yourself']);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
