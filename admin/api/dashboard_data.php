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
    // Recent Users
    $stmtUsers = $conn->query("SELECT id, nome_exibicao, data_criacao FROM usuarios ORDER BY data_criacao DESC LIMIT 5");
    $recentUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Recent Reviews
    $stmtReviews = $conn->query("
        SELECT a.id, a.nota, u.nome_exibicao, v.titulo as viagem_titulo, a.data_criacao 
        FROM avaliacoes a
        LEFT JOIN usuarios u ON a.usuario_id = u.id
        LEFT JOIN viagens v ON a.viagem_id = v.id
        ORDER BY a.data_criacao DESC LIMIT 5
    ");
    $recentReviews = $stmtReviews->fetchAll(PDO::FETCH_ASSOC);

    // Recent Bookings (Reservas)
    $stmtBookings = $conn->query("
        SELECT r.id, u.nome_exibicao, v.titulo as viagem_titulo, r.data_reserva
        FROM reservas r
        LEFT JOIN usuarios u ON r.usuario_id = u.id
        LEFT JOIN viagens v ON r.viagem_id = v.id
        ORDER BY r.data_reserva DESC LIMIT 5
    ");
    $recentBookings = $stmtBookings->fetchAll(PDO::FETCH_ASSOC);

    // Combine and sort by date
    $activities = [];

    foreach ($recentUsers as $user) {
        $activities[] = [
            'type' => 'user',
            'message' => "Novo usuário cadastrado: <strong>{$user['nome_exibicao']}</strong>",
            'date' => $user['data_criacao'],
            'icon' => 'ri-user-add-line',
            'color' => '#4CAF50'
        ];
    }

    foreach ($recentReviews as $review) {
        $activities[] = [
            'type' => 'review',
            'message' => "Nova avaliação de <strong>{$review['nome_exibicao']}</strong> em {$review['viagem_titulo']}",
            'date' => $review['data_criacao'],
            'icon' => 'ri-star-line',
            'color' => '#FFC107'
        ];
    }

    foreach ($recentBookings as $booking) {
        $activities[] = [
            'type' => 'booking',
            'message' => "Nova reserva de <strong>{$booking['nome_exibicao']}</strong> para {$booking['viagem_titulo']}",
            'date' => $booking['data_reserva'],
            'icon' => 'ri-ticket-line',
            'color' => '#2196F3'
        ];
    }

    // Sort by date descending
    usort($activities, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Limit to top 10
    $activities = array_slice($activities, 0, 10);

    // Trips by Continent
    $stmtContinents = $conn->query("SELECT continente, COUNT(*) as count FROM viagens GROUP BY continente");
    $tripsByContinent = $stmtContinents->fetchAll(PDO::FETCH_ASSOC);

    // Top Destinations (by number of reviews for now, as a proxy for popularity)
    // Ideally this would be based on bookings, but let's use reviews count or just random popular ones if no bookings.
    // Let's try to join with reviews to get a count.
    $stmtTopDestinations = $conn->query("
        SELECT v.titulo, COUNT(a.id) as review_count 
        FROM viagens v 
        LEFT JOIN avaliacoes a ON v.id = a.viagem_id 
        GROUP BY v.id 
        ORDER BY review_count DESC 
        LIMIT 5
    ");
    $topDestinations = $stmtTopDestinations->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'activities' => $activities,
        'trips_by_continent' => $tripsByContinent,
        'top_destinations' => $topDestinations
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
