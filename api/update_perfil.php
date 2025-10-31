<?php
include '../config.php';
include '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit;
}

$user_id = $_SESSION['user_id'];
$nome = trim($_POST['nome']);
$bio = trim($_POST['bio']);
$response = ['success' => true];

try {
    // --- Lógica de Upload (Função Helper) ---
    // (Esta função move arquivos enviados para uma pasta 'uploads')
    function handleUpload($fileKey, $user_id) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == 0) {
            $file = $_FILES[$fileKey];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = $fileKey . '_' . $user_id . '_' . time() . '.' . $ext;
            
            // IMPORTANTE: Crie uma pasta 'uploads' na raiz do seu projeto
            $uploadPath = ROOT_PATH . 'uploads/' . $filename; 
            
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return 'uploads/' . $filename; // Retorna o caminho relativo para salvar no banco
            }
        }
        return null;
    }

    $avatar_path = handleUpload('avatar', $user_id);
    $banner_path = handleUpload('banner', $user_id);

    // --- Atualiza o Banco de Dados ---
    // Constrói a query dinamicamente para só atualizar o que foi enviado
    $sql = "UPDATE usuarios SET nome_exibicao = :nome, bio = :bio";
    $params = ['nome' => $nome, 'bio' => $bio, 'id' => $user_id];
    
    if ($avatar_path) {
        $sql .= ", avatar_url = :avatar";
        $params['avatar'] = $avatar_path;
        $response['avatar_url'] = BASE_URL . $avatar_path; // Devolve o novo URL
    }
    if ($banner_path) {
        $sql .= ", banner_url = :banner";
        $params['banner'] = $banner_path;
        $response['banner_url'] = BASE_URL . $banner_path; // Devolve o novo URL
    }
    
    $sql .= " WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Atualiza o nome na sessão
    $_SESSION['user_nome'] = $nome;
    $response['nome'] = $nome;
    $response['bio'] = $bio;

} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>