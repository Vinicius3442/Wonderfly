<?php
// 1. Inclui os arquivos de configuração e conexão
// (Sobe um nível '..' para achar os arquivos na raiz)
include '../config.php';
include '../db_connect.php';

// 2. Verifica se os dados vieram via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Se alguém tentar acessar este arquivo diretamente, manda para a home
    header("Location: " . BASE_URL . "./index.php");
    exit;
}

// 3. Coleta e valida os dados do formulário
// (O seu <input> em login.php tem name="email" e name="senha")
$email = trim($_POST['email']);
$senha = $_POST['senha'];

if (empty($email) || empty($senha)) {
    // Se os campos estiverem vazios, devolve para o login com erro
    $_SESSION['msg_erro'] = "E-mail e senha são obrigatórios.";
    header("Location: " . BASE_URL . "./Login/login.php");
    exit;
}

// 4. Processo de Login (bloco try...catch para pegar erros)
try {
    // 4a. Busca o usuário no banco de dados PELO E-MAIL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 4b. Verifica se o usuário foi ENCONTRADO e se a SENHA BATE
    // password_verify() é a função segura que compara a senha digitada
    // com o 'hash' (senha criptografada) salvo no banco.
    
    if ($user && password_verify($senha, $user['senha_hash'])) {
        
        // --- SUCESSO: O USUÁRIO EXISTE E A SENHA ESTÁ CORRETA ---
        
        // 5. Inicia a Sessão do Usuário
        
        // Regenera o ID da sessão (proteção contra "session fixation")
        session_regenerate_id(true);
        
        // Armazena os dados importantes na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome_exibicao'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['user_avatar'] = $user['avatar_url'];
        
        // 6. Redireciona para a página de perfil
        // (O header.php agora vai ver o $_SESSION['user_id'] e mostrar "Meu Perfil")
        header("Location: " . BASE_URL . "perfil/perfil.php");
        exit;

    } else {
        
        // --- FALHA: Usuário não existe OU a senha está errada ---
        
        $_SESSION['msg_erro'] = "E-mail ou senha inválidos.";
        header("Location: " . BASE_URL . "Login/login.php");
        exit;
    }

} catch (PDOException $e) {
    // 7. Erro de Banco de Dados
    // Loga o erro real para você (admin) ver
    error_log("Erro de Login: " . $e->getMessage()); 
    
    // Manda uma mensagem genérica para o usuário
    $_SESSION['msg_erro'] = "Ocorreu um erro no servidor. Tente novamente mais tarde.";
    header("Location: " . BASE_URL . "Login/login.php");
    exit;
}
?>