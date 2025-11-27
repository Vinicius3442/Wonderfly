<?php
header('Content-Type: application/json');
require_once '../../db_connect.php';

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        // Pagination & Sorting Parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'titulo';
        $order = isset($_GET['order']) && strtoupper($_GET['order']) === 'DESC' ? 'DESC' : 'ASC';

        // Validate Sort Column
        $allowed_sorts = ['id', 'titulo', 'continente', 'preco', 'duracao'];
        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'titulo';
        }

        $offset = ($page - 1) * $limit;

        // 1. Get Total Count
        $countStmt = $conn->query("SELECT COUNT(*) FROM viagens");
        $total_items = $countStmt->fetchColumn();
        $total_pages = ceil($total_items / $limit);

        // 2. Get Data
        $sql = "SELECT id, titulo, continente, preco, duracao, imagem_url 
                FROM viagens 
                ORDER BY $sort $order 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'data' => $trips,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total_items,
                'limit' => $limit
            ]
        ]);
    } 
    elseif ($method === 'DELETE') {
        // Delete a trip
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if ($id) {
            // Delete locations first (foreign key constraint usually handles this if CASCADE is set, but good to be safe or explicit)
            // Our schema has ON DELETE CASCADE for locations, favorites, reviews, etc. so deleting the trip is enough.
            $stmt = $conn->prepare("DELETE FROM viagens WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID required']);
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
