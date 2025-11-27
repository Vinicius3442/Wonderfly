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
    $stats = [];

    // Current User Info
    $stmt = $conn->prepare("SELECT nome_exibicao, avatar_url FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $currentUser = $stmt->fetch();
    $stats['current_user'] = [
        'name' => $currentUser['nome_exibicao'],
        'avatar' => $currentUser['avatar_url']
    ];

    // Total Users
    $stmt = $conn->query("SELECT COUNT(*) as count FROM usuarios");
    $stats['total_users'] = $stmt->fetch()['count'];

    // Total Trips
    $stmt = $conn->query("SELECT COUNT(*) as count FROM viagens");
    $stats['total_trips'] = $stmt->fetch()['count'];

    // Total Blog Posts
    $stmt = $conn->query("SELECT COUNT(*) as count FROM artigos_blog");
    $stats['total_posts'] = $stmt->fetch()['count'];

    // Total Forum Topics
    $stmt = $conn->query("SELECT COUNT(*) as count FROM topicos");
    $stats['total_topics'] = $stmt->fetch()['count'];

    // Recent Users (Last 5)
    $stmt = $conn->query("SELECT id, nome_exibicao, email, data_criacao FROM usuarios ORDER BY data_criacao DESC LIMIT 5");
    $stats['recent_users'] = $stmt->fetchAll();

    // Trips by Continent (for Chart)
    $stmt = $conn->query("SELECT continente, COUNT(*) as count FROM viagens GROUP BY continente");
    $stats['trips_by_continent'] = $stmt->fetchAll();

    echo json_encode($stats);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
