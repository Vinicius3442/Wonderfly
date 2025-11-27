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
$userId = $input['user_id'] ?? null;
$action = $input['action'] ?? null; // 'ban' or 'unban'

if (!$userId || !$action) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

// Prevent banning self
if ($userId == $_SESSION['user_id']) {
    http_response_code(400);
    echo json_encode(['error' => 'Cannot ban yourself']);
    exit;
}

try {
    $isBanned = ($action === 'ban') ? 1 : 0;
    
    $stmt = $conn->prepare("UPDATE usuarios SET is_banned = ? WHERE id = ?");
    $stmt->execute([$isBanned, $userId]);

    echo json_encode(['success' => true, 'message' => "User {$action}ned successfully"]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
