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
    // Retorna ['path' => string, 'error' => string|null]
    function handleUpload($fileKey, $user_id) {
        if (!isset($_FILES[$fileKey])) {
            return ['path' => null, 'error' => null]; // Não enviou arquivo
        }

        $file = $_FILES[$fileKey];

        // Verifica erros do PHP
        if ($file['error'] !== UPLOAD_ERR_OK) {
            // Se for erro 4 (nenhum arquivo), ignora
            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                return ['path' => null, 'error' => null];
            }
            
            // Mapeia erros comuns
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    return ['path' => null, 'error' => "O arquivo '$fileKey' excede o tamanho máximo permitido."];
                case UPLOAD_ERR_PARTIAL:
                    return ['path' => null, 'error' => "O upload do arquivo '$fileKey' foi interrompido."];
                default:
                    return ['path' => null, 'error' => "Erro desconhecido no upload de '$fileKey' (Código: {$file['error']})."];
            }
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowed)) {
             return ['path' => null, 'error' => "Formato de arquivo inválido para '$fileKey'. Use JPG, PNG, GIF ou WEBP."];
        }

        $filename = $fileKey . '_' . $user_id . '_' . time() . '.' . $ext;
        
        // IMPORTANTE: Crie uma pasta 'uploads' na raiz do seu projeto
        $uploadPath = ROOT_PATH . 'uploads/' . $filename; 
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['path' => 'uploads/' . $filename, 'error' => null]; // Retorna o caminho relativo para salvar no banco
        } else {
            return ['path' => null, 'error' => "Falha ao mover o arquivo '$fileKey' para a pasta de destino."];
        }
    }

    $avatar_result = handleUpload('avatar', $user_id);
    $banner_result = handleUpload('banner', $user_id);

    $warnings = [];
    if ($avatar_result['error']) $warnings[] = $avatar_result['error'];
    if ($banner_result['error']) $warnings[] = $banner_result['error'];

    // --- Atualiza o Banco de Dados ---
    // Constrói a query dinamicamente para só atualizar o que foi enviado
    $sql = "UPDATE usuarios SET nome_exibicao = :nome, bio = :bio";
    $params = ['nome' => $nome, 'bio' => $bio, 'id' => $user_id];
    
    if ($avatar_result['path']) {
        $sql .= ", avatar_url = :avatar";
        $params['avatar'] = $avatar_result['path'];
        $response['avatar_url'] = BASE_URL . $avatar_result['path']; // Devolve o novo URL
    }
    if ($banner_result['path']) {
        $sql .= ", banner_url = :banner";
        $params['banner'] = $banner_result['path'];
        $response['banner_url'] = BASE_URL . $banner_result['path']; // Devolve o novo URL
    }
    
    $sql .= " WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Atualiza o nome na sessão
    $_SESSION['user_nome'] = $nome;
    $response['nome'] = $nome;
    $response['bio'] = $bio;

    if (!empty($warnings)) {
        $response['warnings'] = $warnings;
    }

} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>