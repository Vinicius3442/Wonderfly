<?php
include '../config.php';
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Validação (simplificada)
if (empty($_POST['descricao']) || empty($_POST['latitude']) || !isset($_FILES['foto'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

try {
    // --- Lógica de Upload (similar ao update_perfil) ---
    $file = $_FILES['foto'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'momento_' . $user_id . '_' . time() . '.' . $ext;
    
    // IMPORTANTE: Crie uma pasta 'uploads' na raiz
    $uploadPath = ROOT_PATH . 'uploads/' . $filename; 
    $dbPath = 'uploads/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Falha ao mover arquivo.');
    }

    // --- Insere no Banco ---
    $sql = "INSERT INTO momentos (usuario_id, descricao, foto_url, latitude, longitude) 
            VALUES (:user_id, :desc, :foto, :lat, :lng)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'desc' => trim($_POST['descricao']),
        'foto' => $dbPath,
        'lat' => $_POST['latitude'],
        'lng' => $_POST['longitude']
    ]);

    $new_id = $conn->lastInsertId();

    // Devolve o novo momento para o JS adicionar na galeria
    $response = [
        'success' => true,
        'momento' => [
            'id' => $new_id,
            'descricao' => trim($_POST['descricao']),
            'foto_url' => BASE_URL . "./" . $dbPath,
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'data_criacao' => date('Y-m-d H:i:s')
        ]
    ];

} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>