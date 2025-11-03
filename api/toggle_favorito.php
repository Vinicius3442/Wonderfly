<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// 2. GUARDIÃO: Pega o ID da URL
if (!isset($_GET['id'])) {
    // CORRIGIDO: Removido o '/' extra
    header("Location: " . BASE_URL . "Viagem/home_viagem.php");
    exit;
}
$viagem_id = intval($_GET['id']);

// 3. BUSCA OS DADOS DESTA VIAGEM
$viagem = null;
$is_favorito = false; 
$locations = []; // Inicializa para evitar erros

try {
    $stmt = $conn->prepare("SELECT * FROM viagens WHERE id = :id");
    $stmt->execute(['id' => $viagem_id]);
    $viagem = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$viagem) {
        // CORRIGIDO: Removido o '/' extra
        header("Location: " . BASE_URL . "Viagem/home_viagem.php");
        exit;
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $stmt_fav = $conn->prepare("SELECT * FROM favoritos_viagens WHERE usuario_id = :user_id AND viagem_id = :viagem_id");
        $stmt_fav->execute(['user_id' => $user_id, 'viagem_id' => $viagem_id]);
        if ($stmt_fav->fetch()) {
            $is_favorito = true;
        }
    }
    // Busca as localizações do mapa
    $stmt_loc = $conn->prepare("SELECT * FROM viagem_locations WHERE viagem_id = :id");
    $stmt_loc->execute(['id' => $viagem_id]);
    $locations = $stmt_loc->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Erro ao buscar viagem: " . $e->getMessage());
    // CORRIGIDO: Removido o '/' extra
    header("Location: " . BASE_URL . "Viagem/home_viagem.php");
    exit;
}

// 4. Inclui o Header
// CORRIGIDO: Removido o './'
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/viagempage.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<section class="trip-hero">
    <div class="trip-hero-content">
        <span class="badge"><?php echo htmlspecialchars($viagem['categorias']); ?></span>
        <h1><?php echo htmlspecialchars($viagem['titulo']); ?></h1>
        <p><?php echo htmlspecialchars($viagem['descricao_curta']); ?></p>
        
        <ul class="trip-meta">
            <li><i class="ri-time-line"></i> <?php echo htmlspecialchars($viagem['duracao']); ?></li>
            <li><i class="ri-wallet-3-line"></i> a partir de R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></li>
            <li><i class="ri-map-pin-line"></i> <?php echo htmlspecialchars($viagem['keywords']); ?></li>
        </ul>
        <a class="btn primary lg" href="#reserva-form"><i class="ri-check-line"></i> Reservar Agora</a>
    </div>
    
    <div class="trip-hero-gallery">
        <figure class="main-image">
            <img src="<?php echo htmlspecialchars($viagem['imagem_url']); ?>" alt="<?php echo htmlspecialchars($viagem['titulo']); ?>" id="main-gallery-image">
            
            <button 
                class="btn-favorito <?php echo $is_favorito ? 'active' : ''; ?>" 
                data-id="<?php echo $viagem['id']; ?>"
                title="Adicionar à Lista de Desejos"
            >
                <i class="ri-heart-line"></i>
                <i class="ri-heart-fill"></i>
            </button>
        </figure>
        <div class="thumbnail-images">
            <figure class="thumbnail">
                <img src="<?php echo htmlspecialchars($viagem['imagem_url']); ?>" alt="Thumbnail 1">
            </figure>
            </div>
    </div>
</section>

<section class="section trip-details" id="trip-details-content">
    <div class="details-grid">
        <main class="main-content">
            <h2>Sobre esta viagem</h2>
            <?php 
                echo $viagem['descricao_longa'] ?? '<p>Descrição detalhada em breve.</p>'; 
            ?>

            <div class="included">
                <?php 
                    echo $viagem['incluso_html'] ?? '<h3>O que está incluso</h3><p>Em breve...</p>'; 
                ?>
            </div>

            <div class="not-included">
                <?php 
                    echo $viagem['nao_incluso_html'] ?? '<h3>Não incluso</h3><p>Em breve...</p>'; 
                ?>
            </div>

            <div class="itinerary">
                <?php 
                    echo $viagem['itinerario_html'] ?? '<h3>Itinerário detalhado</h3><p>Em breve...</p>'; 
                ?>
            </div>

             <div class="accommodation">
                <?php 
                    echo $viagem['hospedagem_html'] ?? '<h3>Hospedagem selecionada</h3><p>Em breve...</p>'; 
                ?>
            </div>

            <div class="location">
                <h3>Localização no mapa</h3>
                <div id="mapaDestinoUnico" class="map-container"></div>
                </div>
        </main>

        <aside class="sidebar">
            <div class="booking-box" id="reserva-form">
                <h3>Reserve sua aventura</h3>
                <p class="price">A partir de <span>R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></span> por pessoa</p>
                <form id="booking-form-page">
                    <label for="data-viagem">Data da viagem</label>
                    <input type="date" id="data-viagem" name="data-viagem" required>
                    <label for="num-viajantes">Número de viajantes</label>
                    <select id="num-viajantes" name="num-viajantes" required>
                        <option value="1">1 viajante</option>
                        <option value="2" selected>2 viajantes</option>
                    </select>
                    <label for="mensagem">Mensagem (opcional)</label>
                    <textarea id="mensagem" name="mensagem" rows="4" placeholder="Alguma dúvida?"></textarea>
                </form>
                <a href="<?php echo BASE_URL; ?>Pagamento/pagamento.php?viagem_id=<?php echo $viagem['id']; ?>"><button class="btn primary lg full-width">Prosseguir para o Pagamento</button></a>
                <p class="small-text" id="booking-message"></p>
                <p class="small-text">Dúvidas? <a href="<?php echo BASE_URL; ?>Contato/contato.php">Fale com um especialista</a>.</p>
            </div>
            </aside>
    </div>
</section>

<?php
// 5. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="..."></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
    // Passa as localizações do PHP para o JS
    const tripLocations = <?php echo json_encode($locations); ?>;
</script>

<script src="<?php echo BASE_URL; ?>JS/viagem_page.js"></script>
<script src="<?php echo BASE_URL; ?>JS/favoritos.js"></script>

</body>
</html>