<?php
include '../config.php';
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

$user_id = $_SESSION['user_id'];
// Pega o ID enviado pelo JS
$data = json_decode(file_get_contents('php://input'), true);
$momento_id = $data['id'];

if (empty($momento_id)) {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
    exit;
}

try {
    // Pega o caminho do arquivo para deletar do servidor
    $stmt = $conn->prepare("SELECT foto_url FROM momentos WHERE id = :id AND usuario_id = :user_id");
    $stmt->execute(['id' => $momento_id, 'user_id' => $user_id]);
    $momento = $stmt->fetch();

    if ($momento) {
        // Tenta deletar o arquivo físico
        $filePath = ROOT_PATH . $momento['foto_url'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Deleta do banco
        $stmt_del = $conn->prepare("DELETE FROM momentos WHERE id = :id AND usuario_id = :user_id");
        $stmt_del->execute(['id' => $momento_id, 'user_id' => $user_id]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Momento não encontrado ou não pertence a você.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados.']);
}
?>