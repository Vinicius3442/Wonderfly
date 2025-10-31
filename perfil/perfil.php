<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// 2. GUARDIÃO DE AUTENTICAÇÃO
// Se o usuário NÃO ESTIVER LOGADO, chuta ele para a página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "./Login/login.php");
    exit;
}

// 3. BUSCA TODOS OS DADOS DO USUÁRIO
$user_id = $_SESSION['user_id'];
$user = null; // Para guardar os dados do perfil
$favoritos = []; // Para a Lista de Desejos
$momentos = [];  // Para o Mapa de Momentos

try {
    // 3a. Pega os dados do perfil
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
    
    // Se o usuário não for encontrado (ex: deletado), desloga
    if (!$user) {
        header("Location: " . BASE_URL . "./logout.php");
        exit;
    }

    // 3b. Pega a Lista de Desejos (Favoritos)
    $stmt_fav = $conn->prepare("
        SELECT v.* FROM viagens AS v
        JOIN favoritos_viagens AS f ON v.id = f.viagem_id
        WHERE f.usuario_id = :user_id
        ORDER BY f.data_favoritado DESC
    ");
    $stmt_fav->execute(['user_id' => $user_id]);
    $favoritos = $stmt_fav->fetchAll();

    // 3c. Pega os Momentos do mapa
    $stmt_mom = $conn->prepare("SELECT * FROM momentos WHERE usuario_id = :user_id ORDER BY data_criacao DESC");
    $stmt_mom->execute(['user_id' => $user_id]);
    $momentos = $stmt_mom->fetchAll();

    // 3d. CONTAGEM DE VIAGENS FEITAS
    // Conta reservas onde a data da viagem já passou
    $stmt_feitas = $conn->prepare("
        SELECT COUNT(*) FROM reservas 
        WHERE usuario_id = :user_id AND data_viagem < NOW()
    ");
    $stmt_feitas->execute(['user_id' => $user_id]);
    $viagens_feitas_count = $stmt_feitas->fetchColumn();

} catch (PDOException $e) {
    error_log("Erro ao carregar perfil: " . $e->getMessage());
    // (Você pode mostrar uma página de erro aqui)
}

// 4. Prepara variáveis para o HTML (para evitar bugs)
$banner_style = $user['banner_url'] 
    ? 'background-image: url(' . BASE_URL . htmlspecialchars($user['banner_url']) . ');'
    : 'background-color: #eee;'; // Um fallback

$avatar_src = $user['avatar_url']
    ? BASE_URL .  htmlspecialchars($user['avatar_url'])
    : BASE_URL . './images/profile/avatar-default.jpg'; // O padrão do banco

$bio_text = $user['bio']
    ? htmlspecialchars($user['bio'])
    : 'Clique em "Editar Perfil" para adicionar sua bio!';

// 5. Inclui o Header
include ROOT_PATH . './templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>./CSS/perfil.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<main>
    <script src="../JS/perfil.js"></script>
    <section class="profile-header">
        <div class="profile-banner" style="<?php echo $banner_style; ?>"></div>
        
        <div class="profile-info">
            <img src="<?php echo $avatar_src; ?>" alt="Avatar do Usuário" class="profile-avatar" id="profile-avatar">
            
            <h1 class="profile-name" id="profile-name"><?php echo htmlspecialchars($user['nome_exibicao']); ?></h1>
            <p class="profile-bio" id="profile-bio"><?php echo $bio_text; ?></p>
            
            <button class="btn primary small" id="edit-profile-btn">
                <i class="ri-pencil-line"></i> Editar Perfil
            </button>

            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo $viagens_feitas_count; ?></span>
                    <span class="stat-label">Viagens Feitas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($favoritos); ?></span>
                    <span class="stat-label">Na Lista de Desejos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($momentos); ?></span>
                    <span class="stat-label">Momentos Criados</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section profile-content">
        <div class="profile-tabs-nav">
            <button class="tab-link active" data-tab="viagens">Minhas Viagens</button>
            <button class="tab-link" data-tab="momentos">Meus Momentos</button>
        </div>

        <div class="tab-pane active" id="tab-viagens">
            <div class="profile-tabs-nav secondary-tabs">
                <button class="tab-link-secondary" data-tab="atuais">Próximas</button>
                <button class="tab-link-secondary" data-tab="feitas">Já Feitas</button>
                <button class="tab-link-secondary active" data-tab="desejos">Lista de Desejos</button>
            </div>

            <div class="tab-pane-secondary" id="tab-atuais">...</div>
            <div class="tab-pane-secondary" id="tab-feitas">...</div>

            <div class="tab-pane-secondary active" id="tab-desejos">
                <div class="trip-list">
                    <?php if (empty($favoritos)): ?>
                        <p>Você ainda não adicionou viagens à sua lista de desejos.</p>
                    <?php else: ?>
                        <?php foreach ($favoritos as $viagem): ?>
                            <div class="trip-card">
                                <img src="<?php echo BASE_URL . htmlspecialchars($viagem['imagem_url']); ?>" alt="<?php echo htmlspecialchars($viagem['titulo']); ?>">
                                <div class="trip-card-info">
                                    <h3><?php echo htmlspecialchars($viagem['titulo']); ?></h3>
                                    <p>A partir de R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></p>
                                    <span class="badge"><?php echo htmlspecialchars($viagem['categorias']); ?></span>
                                    <a href="#" class="btn primary small">Reservar Agora</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="tab-pane" id="tab-momentos">
            <div class="moments-container">
                <div class="moments-map-area">
                    <h3>Mapa de Momentos</h3>
                    <p>Clique no mapa para adicionar um novo momento!</p>
                    <div id="moments-map"></div>
                    
                    <form id="moment-form" class="moment-form hidden">
                        <h4>Adicionar Novo Momento</h4>
                        <p>Adicionando momento em <span id="moment-coords">Buscando...</span></p>
                        <input type="hidden" id="moment-lat" name="latitude">
                        <input type="hidden" id="moment-lng" name="longitude">
                        
                        <label for="moment-text">Descrição (curta):</label>
                        <input type="text" id="moment-text" name="descricao" placeholder="Melhor café de Paris!" maxlength="100" required>
                        
                        <label for="moment-photo">Foto:</label>
                        <input type="file" id="moment-photo" name="foto" accept="image/*" required>
                        
                        <div class="form-buttons">
                            <button type="submit" class="btn primary small">Salvar Momento</button>
                            <button type="button" id="cancel-moment" class="btn secondary small">Cancelar</button>
                        </div>
                    </form>
                </div>
                
                <div class="moments-gallery-area">
                    <h3>Galeria</h3>
                    <div id="moments-gallery">
                        <?php if (empty($momentos)): ?>
                            <div class="moments-gallery-placeholder" id="gallery-placeholder">
                                <i class="ri-image-add-line"></i>
                                <p>Você ainda não adicionou momentos.</p>
                                <small>Clique no mapa para começar!</small>
                            </div>
                        <?php else: ?>
                            <?php foreach ($momentos as $momento): ?>
                                <div class="moment-card" data-id="<?php echo $momento['id']; ?>">
                                    <img src="<?php echo BASE_URL . htmlspecialchars($momento['foto_url']); ?>" alt="<?php echo htmlspecialchars($momento['descricao']); ?>">
                                    <div class="moment-card-content">
                                        <p><?php echo htmlspecialchars($momento['descricao']); ?></p>
                                        <small>Adicionado em: <?php echo date('d/m/Y', strtotime($momento['data_criacao'])); ?></small>
                                        <div class="moment-card-actions">
                                            <button class="btn-view-map" data-lat="<?php echo $momento['latitude']; ?>" data-lng="<?php echo $momento['longitude']; ?>"><i class="ri-map-pin-line"></i> Ver no Mapa</button>
                                            <button class="btn-delete"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="moments-gallery-placeholder" id="gallery-placeholder" style="<?php echo empty($momentos) ? '' : 'display:none;'; ?>">
                            <i class="ri-image-add-line"></i>
                            <p>Você ainda não adicionou momentos.</p>
                            <small>Clique no mapa para começar!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal" id="profile-edit-modal">
    <div class="modal-content">
        <button class="modal-close" id="modal-close-btn">&times;</button>
        <h2>Editar Perfil</h2>
        
        <form id="profile-edit-form">
            <div class="form-group">
                <label for="edit-avatar">Foto de Perfil</label>
                <input type="file" id="edit-avatar" name="avatar" accept="image/*">
                <small>Deixe em branco para manter a atual.</small>
            </div>
            <div class="form-group">
                <label for="edit-banner">Foto do Banner</label>
                <input type="file" id="edit-banner" name="banner" accept="image/*">
                <small>Deixe em branco para manter a atual.</small>
            </div>
            <div class="form-group">
                <label for="edit-name">Nome</label>
                <input type="text" id="edit-name" name="nome" required value="<?php echo htmlspecialchars($user['nome_exibicao']); ?>">
            </div>
            <div class="form-group">
                <label for="edit-bio">Sua Bio</label>
                <textarea id="edit-bio" name="bio" rows="4" placeholder="Fale um pouco sobre você..."><?php echo htmlspecialchars($user['bio']); ?></textarea>
            </div>
            <button type="submit" class="btn primary full-width">Salvar Alterações</button>
        </form>
    </div>
</div>

<?php
include ROOT_PATH . './templates/footer.php';
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="<?php echo BASE_URL; ?>JS/perfil.js"></script>

<script>
    // Passa os dados do PHP para o JavaScript
    const userMoments = <?php echo json_encode($momentos); ?>;
    const baseUrl = '<?php echo BASE_URL; ?>';
</script>

</body>
</html>