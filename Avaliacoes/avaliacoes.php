<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// 2. LÓGICA DE FILTRO
$filtro = $_GET['filtro'] ?? 'todos'; // Padrão é 'todos'
$usuario_id_logado = $_SESSION['user_id'] ?? null;
$viagens = [];
$avaliacoes = [];

try {
    // 2a. Busca todas as viagens (para o <select> do formulário)
    $stmt_viagens = $conn->prepare("SELECT id, titulo FROM viagens ORDER BY titulo ASC");
    $stmt_viagens->execute();
    $viagens = $stmt_viagens->fetchAll(PDO::FETCH_ASSOC);

    // 2b. Prepara a query de avaliações (com filtro)
    $params = [];
    $sql_reviews = "
        SELECT 
            a.id, a.usuario_id, a.nota, a.mensagem, a.data_criacao,
            u.nome_exibicao, u.avatar_url,
            v.titulo AS viagem_titulo
        FROM avaliacoes AS a
        LEFT JOIN usuarios AS u ON a.usuario_id = u.id
        LEFT JOIN viagens AS v ON a.viagem_id = v.id
    ";

    // Adiciona o filtro SE o usuário clicou em "Minhas Avaliações"
    if ($filtro === 'meus' && $usuario_id_logado) {
        $sql_reviews .= " WHERE a.usuario_id = :user_id";
        $params[':user_id'] = $usuario_id_logado;
    }

    $sql_reviews .= " ORDER BY a.data_criacao DESC";
    
    $stmt_reviews = $conn->prepare($sql_reviews);
    $stmt_reviews->execute($params);
    $avaliacoes = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Erro ao carregar avaliações: " . $e->getMessage());
}

// 3. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/CSS/avaliacoes.css" />

<main>
    <section class="hero-avaliacoes">
        <div class="hero-content">
            <h1>Experiências dos Viajantes</h1>
            <p>Veja o que outros aventureiros têm a dizer e deixe sua própria avaliação!</p>
        </div>
    </section>

    <section class="section" id="criar-avaliacao">
        <div class="section-head">
          <h2>Deixe sua Avaliação</h2>
        </div>
        
        <?php 
            // Exibe mensagens de sucesso/erro (da API)
            exibirMensagens(); 
        ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form id="form-avaliacao" class="form-container" action="<?php echo BASE_URL; ?>api/add_avaliacao.php" method="POST">
              
              <div class="form-group">
                <label for="autor-viagem">Viagem Realizada</label>
                <select id="autor-viagem" name="viagem_id" required>
                    <option value="" disabled selected>-- Selecione a viagem --</option>
                    <?php foreach ($viagens as $viagem): ?>
                        <option value="<?php echo $viagem['id']; ?>">
                            <?php echo htmlspecialchars($viagem['titulo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>
              
              <div class="form-group">
                <label>Sua Nota</label>
                <div class="rating-stars">
                  <input type="radio" name="rating" id="star5" value="5" required/><label for="star5"><i class="fas fa-star"></i></label>
                  <input type="radio" name="rating" id="star4" value="4" /><label for="star4"><i class="fas fa-star"></i></label>
                  <input type="radio" name="rating" id="star3" value="3" /><label for="star3"><i class="fas fa-star"></i></label>
                  <input type="radio" name="rating" id="star2" value="2" /><label for="star2"><i class="fas fa-star"></i></label>
                  <input type="radio" name="rating" id="star1" value="1" /><label for="star1"><i class="fas fa-star"></i></label>
                </div>
              </div>
              
              <div class="form-group">
                <label for="autor-mensagem">Sua Mensagem</label>
                <textarea id="autor-mensagem" name="message" rows="6" placeholder="Conte como foi sua experiência..." required></textarea>
              </div>
              
              <button type="submit" class="btn primary lg">Enviar Avaliação</button>
            </form>
        
        <?php else: ?>
            <div class="form-container-login">
                <p>Você precisa estar logado para deixar uma avaliação.</p>
                <a href="<?php echo BASE_URL; ?>Login/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="btn primary">
                    Fazer Login ou Criar Conta
                </a>
            </div>
        <?php endif; ?>
        
      </section>

      <section class="section alt">
        <div class="section-head">
          <h2><?php echo ($filtro === 'meus') ? 'Minhas Avaliações' : 'Todas as Avaliações'; ?></h2>
        </div>

        <?php if ($usuario_id_logado): // Só mostra filtros se estiver logado ?>
        
        <div class="profile-tabs-nav" id="abas-de-filtro">
            
            <a href="?filtro=todos#abas-de-filtro" class="tab-link <?php echo ($filtro === 'todos') ? 'active' : ''; ?>">
                Todas
            </a>
            <a href="?filtro=meus#abas-de-filtro" class="tab-link <?php echo ($filtro === 'meus') ? 'active' : ''; ?>">
                Minhas Avaliações
            </a>
        </div>
        <?php endif; ?>
        
        <div class="testimonial-grid" id="all-reviews-grid">
          
            <?php if (empty($avaliacoes)): ?>
                <p style="text-align: center; grid-column: 1 / -1;">
                    <?php echo ($filtro === 'meus') ? 'Você ainda não fez nenhuma avaliação.' : 'Ainda não há avaliações.'; ?>
                </p>
            <?php else: ?>
                <?php foreach ($avaliacoes as $review): ?>
                    <div class="testimonial-card" data-id="<?php echo $review['id']; ?>">
                        
                        <?php 
                        // Mostra o botão SÓ SE a avaliação pertencer ao usuário logado
                        if ($usuario_id_logado && $review['usuario_id'] === $usuario_id_logado): 
                        ?>
                            <button class="btn-delete-review" title="Excluir minha avaliação">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        <?php endif; ?>

                        <div class="stars">
                            <?php echo generateStarsHTML($review['nota']); ?>
                        </div>
                        <p class="quote">
                          "<?php echo htmlspecialchars($review['mensagem']); ?>"
                        </p>
                        <div class="profile">
                          <img 
                            src="<?php 
                                echo $review['avatar_url'] 
                                    ? (filter_var($review['avatar_url'], FILTER_VALIDATE_URL) ? htmlspecialchars($review['avatar_url']) : BASE_URL . htmlspecialchars($review['avatar_url']))
                                    : BASE_URL . 'images/profile/default.jpg';
                            ?>" 
                            alt="Foto do Autor" 
                          />
                          <div>
                            <h4><?php echo htmlspecialchars($review['nome_exibicao'] ?? 'Anônimo'); ?></h4>
                            <span>Viagem: <strong><?php echo htmlspecialchars($review['viagem_titulo'] ?? 'Não informada'); ?></strong></span>
                          </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
          
          </div>
      </section>
    </main>

<?php
// 4. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>JS/avaliacoes_acoes.js"></script>

</body>
</html>