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
        // Fetch all blog posts with author name
        $sql = "
            SELECT 
                b.id, 
                b.titulo, 
                b.data_publicacao, 
                u.nome_exibicao as autor
            FROM artigos_blog b
            LEFT JOIN usuarios u ON b.autor_id = u.id
            ORDER BY b.data_publicacao DESC
        ";
        $stmt = $conn->query($sql);
        $posts = $stmt->fetchAll();
        echo json_encode($posts);
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
