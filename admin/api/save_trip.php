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
    $conn->beginTransaction();

    $id = $input['id'] ?? null;
    $titulo = $input['titulo'];
    $preco = $input['preco'];
    $duracao = $input['duracao'];
    $continente = $input['continente'];
    $categorias = $input['categorias'];
    $imagem_url = $input['imagem_url'];
    $descricao_curta = $input['descricao_curta'];
    $descricao_longa = $input['descricao_longa'];
    
    // New HTML fields
    $itinerario_html = $input['itinerario_html'] ?? null;
    $incluso_html = $input['incluso_html'] ?? null;
    $nao_incluso_html = $input['nao_incluso_html'] ?? null;
    $hospedagem_html = $input['hospedagem_html'] ?? null;

    $locations = $input['locations'] ?? [];

    if ($id) {
        // Update existing trip
        $sql = "UPDATE viagens SET titulo=?, preco=?, duracao=?, continente=?, categorias=?, imagem_url=?, descricao_curta=?, descricao_longa=?, itinerario_html=?, incluso_html=?, nao_incluso_html=?, hospedagem_html=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titulo, $preco, $duracao, $continente, $categorias, $imagem_url, $descricao_curta, $descricao_longa, $itinerario_html, $incluso_html, $nao_incluso_html, $hospedagem_html, $id]);
        
        // Update locations: Delete all and re-insert
        $stmt = $conn->prepare("DELETE FROM viagem_locations WHERE viagem_id = ?");
        $stmt->execute([$id]);
    } else {
        // Insert new trip
        $sql = "INSERT INTO viagens (titulo, preco, duracao, continente, categorias, imagem_url, descricao_curta, descricao_longa, itinerario_html, incluso_html, nao_incluso_html, hospedagem_html) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titulo, $preco, $duracao, $continente, $categorias, $imagem_url, $descricao_curta, $descricao_longa, $itinerario_html, $incluso_html, $nao_incluso_html, $hospedagem_html]);
        $id = $conn->lastInsertId();
    }

    // Insert locations
    if (!empty($locations)) {
        $sqlLoc = "INSERT INTO viagem_locations (viagem_id, nome, latitude, longitude) VALUES (?, ?, ?, ?)";
        $stmtLoc = $conn->prepare($sqlLoc);
        foreach ($locations as $loc) {
            $stmtLoc->execute([$id, $loc['name'], $loc['lat'], $loc['lng']]);
        }
    }

    $conn->commit();
    echo json_encode(['success' => true, 'id' => $id]);

} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
