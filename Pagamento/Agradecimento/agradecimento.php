<?php
// 1. Inclui o config (sobe 2 níveis)
include '../../config.php'; 
// Inclui a conexão
include '../../db_connect.php';

// 2. GUARDIÃO DE LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "Login/login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// 3. BUSCA O EMAIL DO USUÁRIO
try {
    $stmt_user = $conn->prepare("SELECT email FROM usuarios WHERE id = :id");
    $stmt_user->execute(['id' => $user_id]);
    $user_email = $stmt_user->fetchColumn(); // Pega só o email

} catch (Exception $e) {
    $user_email = "[E-MAIL NÃO ENCONTRADO]";
    error_log("Erro ao buscar email do usuário: " . $e->getMessage());
}

// 4. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/agradecimento.css">

<main class="thank-you-page-container">
    <div class="thank-you-content">
        <i class="ri-check-double-line success-icon"></i>
        <h1>Pagamento Confirmado! 🎉</h1>
        <p class="main-message">Sua aventura com a WonderFly está confirmada! Prepare-se para embarcar em uma jornada inesquecível.</p>
        
        <div class="details-box">
            <h2>O que acontece agora?</h2>
            <ul>
                <li><i class="ri-mail-line"></i> Um e-mail de confirmação foi enviado para <strong><?php echo htmlspecialchars($user_email); ?></strong>.</li>
                <li><i class="ri-file-text-line"></i> Você pode acessar os detalhes da sua reserva a qualquer momento no seu perfil.</li>
                <li><i class="ri-customer-service-2-line"></i> Nossa equipe de suporte está à disposição para qualquer dúvida!</li>
            </ul>
        </div>

        <p class="secondary-message">Mal podemos esperar para você viver essa experiência única.</p>
        
        <div class="thank-you-ctas">
            <a href="<?php echo BASE_URL; ?>index.php" class="btn primary lg"><i class="ri-home-4-line"></i> Voltar para a Home</a>
            <a href="<?php echo BASE_URL; ?>perfil/perfil.php" class="btn secondary lg"><i class="ri-user-3-line"></i> Acessar Meu Perfil</a>
        </div>
    </div>
</main>

<?php
// 5. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

</body>
</html>