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
        // Fetch all trips
        $sql = "SELECT id, titulo, continente, preco, duracao, imagem_url FROM viagens ORDER BY titulo ASC";
        $stmt = $conn->query($sql);
        $trips = $stmt->fetchAll();
        echo json_encode($trips);
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
