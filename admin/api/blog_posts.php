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
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'data_publicacao';
        $order = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

        // Validate Sort Column
        $allowed_sorts = ['id', 'titulo', 'data_publicacao'];
        if (!in_array($sort, $allowed_sorts)) {
            $sort = 'data_publicacao';
        }

        $offset = ($page - 1) * $limit;

        // 1. Get Total Count
        $countStmt = $conn->query("SELECT COUNT(*) FROM artigos_blog");
        $total_items = $countStmt->fetchColumn();
        $total_pages = ceil($total_items / $limit);

        // 2. Get Data
        $sql = "
            SELECT 
                b.id, 
                b.titulo, 
                b.data_publicacao, 
                b.imagem_destaque_url,
                u.nome_exibicao as autor
            FROM artigos_blog b
            LEFT JOIN usuarios u ON b.autor_id = u.id
            ORDER BY b.$sort $order 
            LIMIT :limit OFFSET :offset
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'data' => $posts,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_items' => $total_items,
                'limit' => $limit
            ]
        ]);
    } 
    elseif ($method === 'DELETE') {
        // Delete a blog post
        // Read JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if ($id) {
            $stmt = $conn->prepare("DELETE FROM artigos_blog WHERE id = ?");
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
