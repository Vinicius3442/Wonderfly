<?php
include '../config.php';
include '../db_connect.php';

// 1. GUARDIÃO: Verifica se está logado e se é POST
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    die("Acesso não autorizado.");
}

$usuario_id = $_SESSION['user_id'];

// 2. Coleta os dados do formulário
$viagem_id = $_POST['viagem_id'] ?? null;
$data_viagem = $_POST['data_viagem'] ?? null;
$payment_method = $_POST['payment_method'] ?? 'cartao';

if (empty($viagem_id) || empty($data_viagem)) {
    $_SESSION['msg_erro'] = "Houve um erro. Tente novamente.";
    header("Location: " . BASE_URL . "Viagem/home_viagem.php");
    exit;
}

// 3. A "SIMULAÇÃO"
// Pausa o script por 2 segundos para parecer real
sleep(2); 

// 4. A PARTE "LEGAL": Salva no banco de dados
try {
    $sql = "INSERT INTO reservas (usuario_id, viagem_id, data_viagem) 
            VALUES (:usuario_id, :viagem_id, :data_viagem)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':viagem_id' => $viagem_id,
        ':data_viagem' => $data_viagem
    ]);

    // 5. Redireciona para a página de Agradecimento com o status correto
    $status = ($payment_method === 'pix') ? 'pending' : 'confirmed';
    
    header("Location: " . BASE_URL . "Pagamento/Agradecimento/agradecimento.php?status=" . $status);
    exit;

} catch (PDOException $e) {
    error_log("Erro ao salvar reserva: " . $e->getMessage());
    $_SESSION['msg_erro'] = "Seu pagamento foi simulado, mas houve um erro ao salvar sua reserva.";
    header("Location: " . BASE_URL . "Pagamento/pagamento.php?viagem_id=" . $viagem_id);
    exit;
}
?>