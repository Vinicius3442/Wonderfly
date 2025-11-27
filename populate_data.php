<?php
include 'config.php';
include 'db_connect.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    // Tenta pegar o primeiro usuário se não estiver logado (apenas para teste)
    $stmt = $conn->query("SELECT id FROM usuarios LIMIT 1");
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        echo "Logado temporariamente como usuário ID: " . $user['id'] . "<br>";
    } else {
        die("Nenhum usuário encontrado no banco. Crie um usuário primeiro.");
    }
}

$user_id = $_SESSION['user_id'];

// 1. Limpa reservas e favoritos antigos deste usuário (opcional, para não duplicar)
// $conn->exec("DELETE FROM reservas WHERE usuario_id = $user_id");
// $conn->exec("DELETE FROM favoritos_viagens WHERE usuario_id = $user_id");

// 2. Busca algumas viagens para usar
$stmt_v = $conn->query("SELECT id FROM viagens LIMIT 5");
$viagens = $stmt_v->fetchAll(PDO::FETCH_COLUMN);

if (count($viagens) < 3) {
    die("Precisa de pelo menos 3 viagens cadastradas no banco para este teste.");
}

// 3. Insere Favoritos (Viagem 1 e 2)
try {
    $stmt_fav = $conn->prepare("INSERT IGNORE INTO favoritos_viagens (usuario_id, viagem_id) VALUES (?, ?)");
    $stmt_fav->execute([$user_id, $viagens[0]]);
    $stmt_fav->execute([$user_id, $viagens[1]]);
    echo "Favoritos inseridos.<br>";
} catch (Exception $e) {
    echo "Erro ao inserir favoritos: " . $e->getMessage() . "<br>";
}

// 4. Insere Viagem Passada (Viagem 1, data mês passado)
try {
    $data_passada = date('Y-m-d', strtotime('-1 month'));
    // Removido 'status' e 'num_viajantes'
    $stmt_res = $conn->prepare("INSERT INTO reservas (usuario_id, viagem_id, data_viagem) VALUES (?, ?, ?)");
    $stmt_res->execute([$user_id, $viagens[0], $data_passada]);
    echo "Viagem passada inserida.<br>";
} catch (Exception $e) {
    echo "Erro ao inserir viagem passada: " . $e->getMessage() . "<br>";
}

// 5. Insere Viagem Futura (Viagem 2, data mês que vem)
try {
    $data_futura = date('Y-m-d', strtotime('+1 month'));
    // Re-prepara o statement ou reutiliza se for a mesma query (aqui é a mesma)
    $stmt_res->execute([$user_id, $viagens[1], $data_futura]);
    echo "Viagem futura inserida.<br>";
} catch (Exception $e) {
    echo "Erro ao inserir viagem futura: " . $e->getMessage() . "<br>";
}

echo "Dados de teste populados com sucesso! Verifique o perfil.";
?>
