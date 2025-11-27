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
    echo json_encode(['error' => 'ID required']);
    exit;
}

try {
    // Fetch trip details
    $stmt = $conn->prepare("SELECT * FROM viagens WHERE id = ?");
    $stmt->execute([$id]);
    $trip = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$trip) {
        http_response_code(404);
        echo json_encode(['error' => 'Trip not found']);
        exit;
    }

    // Fetch locations
    $stmtLoc = $conn->prepare("SELECT nome, latitude, longitude FROM viagem_locations WHERE viagem_id = ?");
    $stmtLoc->execute([$id]);
    $trip['locations'] = $stmtLoc->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($trip);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
