<?php
include '../config.php';
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location:" . BASE_URL . "./index.php");
    exit;
}

// 2. Coleta e limpa os dados
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];
$senha_confirm = $_POST['senha_confirm'];

// 3. Validação dos dados
if (empty($nome) || empty($email) || empty($senha)) {
    $_SESSION['msg_erro'] = "Todos os campos são obrigatórios.";
    header("Location:" . BASE_URL . "./Login/Cadastro/cadastro.php");
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['msg_erro'] = "Formato de e-mail inválido.";
    header("Location:" . BASE_URL . " ./Login/Cadastro/cadastro.php");
    exit;
}
if (strlen($senha) < 8) {
    $_SESSION['msg_erro'] = "A senha deve ter no mínimo 8 caracteres.";
    header("Location:" . BASE_URL . " ./Login/Cadastro/cadastro.php");
    exit;
}
if ($senha !== $senha_confirm) {
    $_SESSION['msg_erro'] = "As senhas não conferem.";
    header("Location:" . BASE_URL . " ./Login/Cadastro/cadastro.php");
    exit;
}
if (!isset($_POST['aceitarTermos'])) {
    $_SESSION['msg_erro'] = "Você deve aceitar os termos de uso.";
    header("Location:" . BASE_URL . " ./Login/Cadastro/cadastro.php");
    exit;
}

// 4. Verifica se o e-mail já existe no banco
try {
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['msg_erro'] = "Este e-mail já está cadastrado. Tente fazer login.";
        header("Location: " . BASE_URL . "./Login/Cadastro/cadastro.php");
        exit;
    }

    // 5. CRÍTICO: Criptografa a senha
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

    // 6. Insere o novo usuário no banco
    $sql = "INSERT INTO usuarios (nome_exibicao, email, senha_hash) VALUES (:nome, :email, :hash)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'hash' => $hash_senha
    ]);

    // 7. Loga o usuário automaticamente
    $user_id = $conn->lastInsertId();
    session_regenerate_id(true); 
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_nome'] = $nome;
    $_SESSION['is_admin'] = 0; // Padrão

    // 8. Redireciona para o perfil
    header("Location: " . BASE_URL . "./perfil/perfil.php");
    exit;

} catch (PDOException $e) {
    error_log("Erro no registro: " . $e->getMessage()); 
    $_SESSION['msg_erro'] = "Erro interno. Por favor, tente novamente mais tarde.";
    header("Location: " . BASE_URL . " ./Login/Cadastro/cadastro.php");
    exit;
}
?>