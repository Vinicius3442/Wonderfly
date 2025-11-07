<?php
// 1. Define o título da página (para o header)
$page_title = 'Dashboard';

// 2. Inclui o Guardião (que também inclui config e db)
include 'admin_guardian.php';

// 3. BUSCA OS DADOS REAIS DO BANCO
$stats = [
    'faturamento_bruto' => 0,
    'usuarios_count' => 0,
    'reservas_count' => 0,
    'topicos_count' => 0
];
$reservas_recentes = [];
$ai_insight = [
    'top_viagem_fav' => 'N/A',
    'top_viagem_res' => 'N/A',
    'top_user' => 'N/A'
];

try {
    // 3a. Estatísticas dos Cards
    // (SUM(v.preco) é o seu Faturamento Bruto)
    $faturamento_bruto = $conn->query("
        SELECT SUM(v.preco) 
        FROM reservas r 
        JOIN viagens v ON r.viagem_id = v.id
    ")->fetchColumn();
    $stats['faturamento_bruto'] = $faturamento_bruto !== false ? (float)$faturamento_bruto : 0; // Garante que é um float, ou 0

    $stats['usuarios_count'] = (int)$conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    $stats['reservas_count'] = (int)$conn->query("SELECT COUNT(*) FROM reservas")->fetchColumn();
    $stats['topicos_count'] = (int)$conn->query("SELECT COUNT(*) FROM topicos")->fetchColumn();

    // 3b. Dados para os Insights da IA
    // Viagem mais favoritada
    $top_viagem_fav = $conn->query("
        SELECT v.titulo, COUNT(f.viagem_id) AS fav_count 
        FROM favoritos_viagens f 
        JOIN viagens v ON f.viagem_id = v.id 
        GROUP BY f.viagem_id 
        ORDER BY fav_count DESC 
        LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);
    $ai_insight['top_viagem_fav'] = $top_viagem_fav['titulo'] ?? 'N/A';

    // Viagem mais reservada
    $top_viagem_res = $conn->query("
        SELECT v.titulo, COUNT(r.viagem_id) AS res_count 
        FROM reservas r 
        JOIN viagens v ON r.viagem_id = v.id 
        GROUP BY r.viagem_id 
        ORDER BY res_count DESC 
        LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);
    $ai_insight['top_viagem_res'] = $top_viagem_res['titulo'] ?? 'N/A';
    
    // Usuário mais ativo (mais posts)
    $top_user = $conn->query("
        SELECT u.nome_exibicao, COUNT(t.id) AS post_count 
        FROM topicos t 
        JOIN usuarios u ON t.usuario_id = u.id 
        GROUP BY t.usuario_id 
        ORDER BY post_count DESC 
        LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);
    $ai_insight['top_user'] = $top_user['nome_exibicao'] ?? 'N/A';


    // 3c. Pega as 5 Reservas Mais Recentes
    $sql_reservas = "
        SELECT r.id, r.data_reserva, r.data_viagem, u.nome_exibicao, v.titulo AS viagem_titulo
        FROM reservas AS r
        JOIN usuarios AS u ON r.usuario_id = u.id
        JOIN viagens AS v ON r.viagem_id = v.id
        ORDER BY r.data_reserva DESC
        LIMIT 5
    ";
    $reservas_recentes = $conn->query($sql_reservas)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em produção, você deve LOGAR o erro, não exibi-lo.
    // Para fins de desenvolvimento, podemos exibi-lo.
    // Recomendo usar error_log($e->getMessage()); e exibir uma mensagem genérica para o usuário.
    // Por exemplo, $db_error = "Não foi possível carregar os dados do dashboard. Tente novamente mais tarde.";
    $db_error_message = "Erro de banco de dados: " . $e->getMessage();
    // Você pode usar isso para debugging, mas não em produção.
    // die($db_error_message); 
}

// 4. Inclui o Header (Sidebar e Topo)
include 'templates/header.php';
?>

<div class="admin-content">
    <h1>Dashboard de Administrador</h1>
    <?php if (isset($db_error_message)) echo "<p class='error-message'>Erro: " . htmlspecialchars($db_error_message) . "</p>"; ?>

    <div class="stat-cards">
        <div class="stat-card">
            <i class="ri-wallet-line icon-bookings"></i>
            <div class="info">
                <span class="number-money">R$ <?php echo number_format($stats['faturamento_bruto'], 2, ',', '.'); ?></span>
                <span class="label">Faturamento Bruto (Total)</span>
            </div>
        </div>
        <div class="stat-card">
            <i class="ri-user-line icon-users"></i>
            <div class="info">
                <span class="number"><?php echo htmlspecialchars($stats['usuarios_count']); ?></span>
                <span class="label">Usuários Totais</span>
            </div>
        </div>
        <div class="stat-card">
            <i class="ri-shopping-cart-line icon-trips"></i>
            <div class="info">
                <span class="number"><?php echo htmlspecialchars($stats['reservas_count']); ?></span>
                <span class="label">Reservas Feitas</span>
            </div>
        </div>
        <div class="stat-card">
            <i class="ri-discuss-line icon-forum"></i>
            <div class="info">
                <span class="number"><?php echo htmlspecialchars($stats['topicos_count']); ?></span>
                <span class="label">Tópicos no Fórum</span>
            </div>
        </div>
    </div>

    <div class="ai-insights">
        <div class="ai-insights-header">
            <i class="ri-robot-2-line"></i>
            <h2>Insights da IA (Simulado por Gemini)</h2>
        </div>
        <div class="insight-list">
            <div class="insight-item">
                <p>
                    <strong>Análise de Popularidade:</strong> A viagem mais *favoritada* no momento é <strong>'<?php echo htmlspecialchars($ai_insight['top_viagem_fav']); ?>'</strong>. A mais *reservada* é <strong>'<?php echo htmlspecialchars($ai_insight['top_viagem_res']); ?>'</strong>.
                    
                    <?php if ($ai_insight['top_viagem_fav'] !== 'N/A' && $ai_insight['top_viagem_fav'] !== $ai_insight['top_viagem_res']): ?>
                    <span class="suggestion">
                        <strong>Ação Sugerida:</strong> A viagem '<?php echo htmlspecialchars($ai_insight['top_viagem_fav']); ?>' tem alta intenção e baixa conversão. Crie um post no blog ou um cupom de 5% para ela.
                    </span>
                    <?php else: ?>
                    <span class="suggestion">
                        <strong>Insight:</strong> Sua viagem mais popular é também a mais vendida. Ótimo trabalho!
                    </span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="insight-item">
                <p>
                    <strong>Engajamento da Comunidade:</strong> Seu usuário mais ativo no fórum (mais posts criados) é <strong>'<?php echo htmlspecialchars($ai_insight['top_user']); ?>'</strong>.
                    <span class="suggestion">
                        <strong>Ação Sugerida:</strong> Considere dar a este usuário uma "medalha" de "Viajante Mestre" no perfil ou um pequeno cupom de desconto.
                    </span>
                </p>
            </div>
            <div class="insight-item">
                <p>
                    <strong>Nota sobre Faturamento:</strong> O Faturamento "Líquido" não pode ser calculado.
                    <span class="suggestion">
                        <strong>Ação Sugerida:</strong> Para calcular o lucro líquido, vá em "Gerir Viagens" e adicione uma coluna `custo_operacional` (em R$) na sua tabela `viagens`.
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <h2>Últimas 5 Reservas</h2>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Viagem</th>
                    <th>Data da Viagem</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservas_recentes)): ?>
                    <tr><td colspan="4" style="text-align: center;">Nenhuma reserva encontrada.</td></tr>
                <?php else: ?>
                    <?php foreach ($reservas_recentes as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['nome_exibicao']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['viagem_titulo']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($reserva['data_viagem'])); ?></td>
                            <td>
                                <?php if (strtotime($reserva['data_viagem']) < time()): ?>
                                    <span class="status-ok">Concluída</span>
                                <?php else: ?>
                                    <span class="status-pending">Próxima</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// 5. Inclui o Footer
include 'templates/footer.php';
?>