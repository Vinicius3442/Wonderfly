<?php
include '../config.php';
include '../db_connect.php';

header('Content-Type: application/json');

// 1. GUARDIÃO: Verifica se está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
    exit;
}
$user_id = $_SESSION['user_id'];

// 2. Validação
if (empty($_POST['subject']) || empty($_POST['message'])) {
    echo json_encode(['success' => false, 'message' => 'Assunto e Mensagem são obrigatórios.']);
    exit;
}

$board = $_POST['board'];
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);
$dbPath = null; // Caminho da imagem (opcional)

try {
    // 3. Lógica de Upload de Imagem (igual ao perfil)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $file = $_FILES['imagem'];
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        // Salva na pasta 'uploads/'
        $filename = 'forum_' . $user_id . '_' . time() . '.' . $ext;
        $uploadPath = ROOT_PATH . 'uploads/' . $filename; 
        $dbPath = 'uploads/' . $filename; // Caminho para salvar no banco

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Falha ao mover arquivo.');
        }
    }

    // 4. Insere no Banco
    $sql = "INSERT INTO topicos (usuario_id, board, assunto, mensagem, imagem_url) 
            VALUES (:user_id, :board, :subject, :message, :image_url)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'board' => $board,
        'subject' => $subject,
        'message' => $message,
        'image_url' => $dbPath
    ]);

    echo json_encode(['success' => true, 'message' => 'Tópico criado com sucesso!']);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
}
?>