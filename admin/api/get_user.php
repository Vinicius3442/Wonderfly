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
    // Fetch user details
    $stmt = $conn->prepare("SELECT id, nome_exibicao, email, is_admin, bio, avatar_url, data_criacao FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }
    
    // Map is_admin to type
    $user['tipo'] = $user['is_admin'] ? 'admin' : 'usuario';

    // Fetch stats
    // 1. Reviews count
    $stmtReviews = $conn->prepare("SELECT COUNT(*) FROM avaliacoes WHERE usuario_id = ?");
    $stmtReviews->execute([$id]);
    $reviewsCount = $stmtReviews->fetchColumn();

    // 2. Favorites count
    $stmtFavorites = $conn->prepare("SELECT COUNT(*) FROM favoritos_viagens WHERE usuario_id = ?");
    $stmtFavorites->execute([$id]);
    $favoritesCount = $stmtFavorites->fetchColumn();

    // 3. Forum topics count (assuming table 'topicos')
    $topicsCount = 0;
    try {
        $stmtTopics = $conn->prepare("SELECT COUNT(*) FROM topicos WHERE autor_id = ?");
        $stmtTopics->execute([$id]);
        $topicsCount = $stmtTopics->fetchColumn();
    } catch (Exception $e) {
        // Table might not exist yet
    }

    $user['stats'] = [
        'reviews' => $reviewsCount,
        'favorites' => $favoritesCount,
        'topics' => $topicsCount
    ];

    echo json_encode($user);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
