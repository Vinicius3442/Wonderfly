<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// 2. BUSCA TODAS AS VIAGENS E FAVORITOS
$viagens = [];
$meus_favoritos_ids = []; // Array para guardar os IDs das viagens que o usuário já favoritou

try {
    // 3a. Pega todas as viagens
    $stmt = $conn->prepare("SELECT * FROM viagens ORDER BY titulo ASC");
    $stmt->execute();
    $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3b. Busca a primeira localização de cada viagem para o mapa
    foreach ($viagens as &$v) {
        $stmt_loc = $conn->prepare("SELECT latitude, longitude FROM viagem_locations WHERE viagem_id = :id LIMIT 1");
        $stmt_loc->execute(['id' => $v['id']]);
        $loc = $stmt_loc->fetch(PDO::FETCH_ASSOC);
        if ($loc) {
            $v['latitude'] = $loc['latitude'];
            $v['longitude'] = $loc['longitude'];
        } else {
            // Fallback ou null se não tiver localização
            $v['latitude'] = null;
            $v['longitude'] = null;
        }
    }
    unset($v); // Quebra a referência

    // 3b. Se o usuário estiver logado, pega os favoritos dele
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $stmt_fav = $conn->prepare("SELECT viagem_id FROM favoritos_viagens WHERE usuario_id = :user_id");
        $stmt_fav->execute(['user_id' => $user_id]);
        
        // Mapeia o resultado para um array simples (ex: [1, 5, 12])
        $meus_favoritos_ids = $stmt_fav->fetchAll(PDO::FETCH_COLUMN);
    }

} catch (PDOException $e) {
    error_log("Erro ao buscar viagens: " . $e->getMessage());
}

// 4. Inclui o Header
include ROOT_PATH . './templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/CSS/home_viagem.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<main>
    <section class="hero-viagem">
        <div class="hero-viagem-content">
            <h1>Descubra Experiências Inesquecíveis</h1>
            <p>Encontre sua próxima aventura cultural, gastronômica ou de natureza.</p>
            <div class="search-container">
                <select id="continent-filter">
                    <option value="all">Todos os Continentes</option>
                    <option value="america-sul">América do Sul</option>
                    <option value="america-norte">América do Norte</option>
                    <option value="europa">Europa</option>
                    <option value="asia">Ásia</option>
                    <option value="africa">África</option>
                </select>
                <input
                  type="text"
                  id="search-input"
                  placeholder="Pesquisar destino, tema ou palavras-chave..."
                />
                <button class="btn primary" id="search-button">
                  <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="section-head">
            <h2>Explore por Tema</h2>
            <a href="#all-destination-cards" class="link" id="ver-todos-link">Ver todos &rarr;</a>
        </div>
        <div class="themes" id="theme-chips-container">
            <button class="chip active" data-filter="all">Todos</button>
            <button class="chip" data-filter="aventura">Aventura</button>
            <button class="chip" data-filter="relaxamento">Relaxamento</button>
            <button class="chip" data-filter="historia">História</button>
            <button class="chip" data-filter="gastronomia">Gastronomia</button>
            <button class="chip" data-filter="natureza">Natureza Selvagem</button>
            <button class="chip" data-filter="cultura">Imersão Cultural</button>
        </div>

        <div class="grid cards" id="all-destination-cards">
            
            <?php if (empty($viagens)): ?>
                <p style="text-align: center; grid-column: 1 / -1;">Nenhuma viagem encontrada no momento.</p>
            <?php else: ?>
                
                <?php foreach ($viagens as $viagem): ?>
                    <?php
                        // Verifica se esta viagem está na lista de favoritos do usuário
                        $is_favorito = in_array($viagem['id'], $meus_favoritos_ids);
                    ?>
                
                    <div
                        class="card"
                        data-continent="<?php echo htmlspecialchars($viagem['continente']); ?>"
                        data-category="<?php echo htmlspecialchars($viagem['categorias']); ?>"
                        data-keywords="<?php echo htmlspecialchars($viagem['keywords']); ?>"
                    >
                        <div
                          class="card-img"
                          style="background-image: url('<?php echo htmlspecialchars($viagem['imagem_url']); ?>');"
                        >
                            <button 
                                class="btn-favorito <?php echo $is_favorito ? 'active' : ''; ?>" 
                                data-id="<?php echo $viagem['id']; ?>"
                                title="Adicionar à Lista de Desejos"
                            >
                                <i class="ri-heart-line"></i>
                                <i class="ri-heart-fill"></i>
                            </button>
                        </div>
                        <div class="card-body">
                          <h3><?php echo htmlspecialchars($viagem['titulo']); ?></h3>
                          <p>
                            <?php echo htmlspecialchars($viagem['descricao_curta']); ?>
                          </p>
                          <div class="meta">
                            <span><i class="fa-solid fa-clock"></i> <?php echo htmlspecialchars($viagem['duracao']); ?></span>
                            <span>a partir de R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></span>
                          </div>
                          <a href="<?php echo BASE_URL; ?>Viagem/viagem.php?id=<?php echo $viagem['id']; ?>" class="btn secondary">
                            Ver detalhes
                          </a>
                        </div>
                    </div>

                <?php endforeach; ?>
                <?php endif; ?>

        </div>
    </section>

    <section class="section">
        <div class="section-head">
          <h2>Onde no Mapa?</h2>
          <span>Encontre seus destinos favoritos ou descubra novas aventuras globalmente.</span>
        </div>
        <div id="mapaDestinos"></div>
    </section>
    
    <section class="cta-newsletter">
        </section>
</main>

<button id="back-to-top" class="back-to-top">
  <i class="ri-arrow-up-line"></i>
</button>

<?php
// 5. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
    const allTrips = <?php echo json_encode($viagens); ?>;
</script>

<script src="<?php echo BASE_URL; ?>/JS/home_viagem.js"></script>
<script src="<?php echo BASE_URL; ?>/JS/favoritos.js"></script> 

</body>
</html>