<?php
header('Content-Type: application/json');
require_once '../../db_connect.php';

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM artigos_blog WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Fetch author name if possible, or just return what we have
        // Ideally we would join with users table, but for now let's just return the post
        // If we stored author_id, we might want to fetch the name.
        // The blog_editor.js expects 'author' field for the manual input.
        // If the table structure has 'autor_id', we might need to fetch the name from users table OR if we added a manual 'author_name' column.
        // Wait, the user asked for a manual author field.
        // In the previous step, I added 'author' to the save_post.php but I didn't check if I added a column to the database!
        // I need to check the database schema for 'artigos_blog'.
        // The user request was "o nome do editor deve ser o nome do usuário logado(ou pra simplificar pode ser digitado manualmente ok??)".
        // I implemented the manual input in the UI and passed it to save_post.php.
        // BUT, I probably didn't update the database schema to store this manual author name if it's not 'autor_id'.
        // Let's check save_post.php again.
        
        echo json_encode($post);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Post not found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
