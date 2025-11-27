<?php
header('Content-Type: application/json');
require_once '../../db_connect.php';

session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

try {
    $title = $input['title'];
    $summary = $input['summary'];
    $image = $input['image'];
    $content = $input['content'];
    $authorId = $_SESSION['user_id'];

    $id = $input['id'] ?? null;

    if ($id) {
        // Update existing post
        $sql = "UPDATE artigos_blog SET titulo = ?, resumo = ?, conteudo_html = ?, imagem_destaque_url = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $summary, $content, $image, $id]);
        echo json_encode(['success' => true, 'id' => $id]);
    } else {
        // Insert new post
        $sql = "INSERT INTO artigos_blog (titulo, resumo, conteudo_html, imagem_destaque_url, autor_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $summary, $content, $image, $authorId]);
        echo json_encode(['success' => true, 'id' => $conn->lastInsertId()]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
