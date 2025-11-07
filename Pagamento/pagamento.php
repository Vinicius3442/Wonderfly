<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// 2. GUARDIÃO DE LOGIN
// Se não estiver logado, manda para o login (e ?redirect= de volta para cá)
if (!isset($_SESSION['user_id'])) {
    $redirect_url = $_SERVER['REQUEST_URI'];
    header("Location: " . BASE_URL . "Login/login.php?redirect=" . urlencode($redirect_url));
    exit;
}
$user_id = $_SESSION['user_id'];

// 3. GUARDIÃO DE VIAGEM
// Pega o ID da viagem da URL (ex: ...?viagem_id=1)
if (!isset($_GET['viagem_id'])) {
    $_SESSION['msg_erro'] = "Nenhuma viagem selecionada.";
    header("Location: " . BASE_URL . "Viagem/home_viagem.php");
    exit;
}
$viagem_id = intval($_GET['viagem_id']);

// 4. BUSCA OS DADOS DA VIAGEM E DO USUÁRIO
try {
    // Busca a Viagem
    $stmt_viagem = $conn->prepare("SELECT * FROM viagens WHERE id = :id");
    $stmt_viagem->execute(['id' => $viagem_id]);
    $viagem = $stmt_viagem->fetch(PDO::FETCH_ASSOC);

    // Busca o Usuário
    $stmt_user = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt_user->execute(['id' => $user_id]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$viagem || !$user) {
        throw new Exception("Viagem ou usuário não encontrado.");
    }

} catch (Exception $e) {
    $_SESSION['msg_erro'] = $e->getMessage();
    header("Location: " . BASE_URL . "Viagem/home_viagem.php");
    exit;
}

// 5. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/pagamento.css">

<main class="payment-page-container">
    <div class="payment-header">
        <h1>Finalizar Pagamento</h1>
        <p>Seu roteiro para explorar culturas autênticas está a um passo!</p>
    </div>

    <section class="payment-section">
        
        <div class="order-summary">
            <h2>Resumo do seu Pedido</h2>
            <div class="summary-item">
                <span>Destino:</span>
                <strong><?php echo htmlspecialchars($viagem['titulo']); ?></strong>
            </div>
            <div class="summary-item">
                <span>Duração:</span>
                <span><?php echo htmlspecialchars($viagem['duracao']); ?></span>
            </div>
            <div class="summary-item">
                <span>Valor por pessoa:</span>
                <span>R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></span>
            </div>
            <div class="summary-item total">
                <span>Total:</span>
                <strong>R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></strong>
            </div>
        </div>

        <div class="payment-form-container">
            <form class="payment-form" id="payment-form" action="<?php echo BASE_URL; ?>api/processar_pagamento.php" method="POST">
                
                <input type="hidden" name="viagem_id" value="<?php echo $viagem['id']; ?>">
                <input type="hidden" name="valor_total" value="<?php echo $viagem['preco']; ?>">

                <h2>Informações de Contato</h2>
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome_exibicao']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="data-viagem">Data de Início da Viagem</label>
                    <input type="date" id="data-viagem" name="data_viagem" required>
                </div>

                <h2>Endereço de Cobrança</h2>
                <p style="padding: 10px; background: #f4f4f4; border-radius: 8px; text-align: center;">
                    Usaremos o endereço de cobrança salvo no seu perfil.
                </p>

                <h2>Método de Pagamento</h2>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="payment-method" value="cartao" checked>
                        <i class="ri-credit-card-line"></i> Cartão de Crédito
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment-method" value="pix">
                        <i class="ri-qrcode-line"></i> PIX
                    </label>
                </div>

                <div class="secure-info">
                    <i class="ri-lock-line"></i> Este é um ambiente de simulação.
                </div>

                <button type="submit" class="btn primary lg pay-button" id="pay-button">
                    <i class="ri-check-line"></i> Finalizar Pagamento
                </button>
            </form>
            
        </div>
    </section>
</main>

<?php
// 6. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script>
    // Script para simular o "carregando"
    const form = document.getElementById('payment-form');
    const btn = document.getElementById('pay-button');

    if(form) {
        form.addEventListener('submit', () => {
            btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Processando...';
            btn.disabled = true;
        });
    }
</script>
</body>
</html>