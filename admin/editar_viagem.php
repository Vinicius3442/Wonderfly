<?php
// 1. Define o 'slug' e 'título'
$page_slug = 'gerir_viagens';
$page_title = 'Editor de Viagem';

// 2. Inclui o Guardião
include 'admin_guardian.php';

// 3. Lógica de Edição vs. Criação (IDÊNTICA A ANTES)
$viagem_id = $_GET['id'] ?? null;
$is_editing = !is_null($viagem_id);
$viagem = [
    'titulo' => '', 'descricao_curta' => '', 'preco' => '', 'duracao' => '',
    'imagem_url' => '', 'continente' => '', 'categorias' => '', 'keywords' => '',
    'descricao_longa' => '', 'incluso_html' => '', 'nao_incluso_html' => '',
    'itinerario_html' => '', 'hospedagem_html' => ''
];
$locations = [];

if ($is_editing) {
    $page_title = 'Editar Viagem: ' . ($viagem['titulo'] ?? '');
    // Busca Viagem
    $stmt_viagem = $conn->prepare("SELECT * FROM viagens WHERE id = :id");
    $stmt_viagem->execute(['id' => $viagem_id]);
    $viagem = $stmt_viagem->fetch(PDO::FETCH_ASSOC);
    // Busca Locais do Mapa
    $stmt_loc = $conn->prepare("SELECT * FROM viagem_locations WHERE viagem_id = :id");
    $stmt_loc->execute(['id' => $viagem_id]);
    $locations = $stmt_loc->fetchAll(PDO::FETCH_ASSOC);
} else {
    $page_title = 'Criar Nova Viagem';
}

// 4. Inclui o Header (O do Admin, com a sidebar)
include 'templates/header.php';
?>

<form class="editor-form" id="viagem-form" action="<?php echo BASE_URL; ?>api/admin_salvar_viagem.php" method="POST">
    
    <?php if ($is_editing): ?>
        <input type="hidden" name="viagem_id" value="<?php echo $viagem['id']; ?>">
    <?php endif; ?>
    
    <button type="submit" class="btn primary btn-save">
        <i class="ri-save-line"></i> Salvar Viagem
    </button>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/viagempage.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/editar_viagem_style.css">


    <section class="trip-hero">
        <div class="trip-hero-content">
            <input type="text" class="edit-field badge" name="categorias" 
                   value="<?php echo htmlspecialchars($viagem['categorias']); ?>" 
                   placeholder="Categorias (ex: aventura historia)">
            
            <input type="text" class="edit-field" name="titulo" 
                   value="<?php echo htmlspecialchars($viagem['titulo']); ?>" 
                   placeholder="Título da Viagem" required>
            
            <textarea class="edit-field" name="descricao_curta" 
                      placeholder="Descrição curta (para o card)..."><?php echo htmlspecialchars($viagem['descricao_curta']); ?></textarea>
            
            <ul class="trip-meta">
                <li>
                    <i class="ri-time-line"></i> 
                    <input type="text" class="edit-field" name="duracao" 
                           value="<?php echo htmlspecialchars($viagem['duracao']); ?>" 
                           placeholder="Duração (ex: 8 dias)">
                </li>
                <li>
                    <i class="ri-wallet-3-line"></i> 
                    <input type="text" class="edit-field" name="preco" 
                           value="<?php echo htmlspecialchars($viagem['preco']); ?>" 
                           placeholder="Preço (ex: 4100.00)">
                </li>
                <li>
                    <i class="ri-map-pin-line"></i>
                    <input type="text" class="edit-field" name="keywords" 
                           value="<?php echo htmlspecialchars($viagem['keywords']); ?>" 
                           placeholder="Keywords (ex: peru incas)">
                </li>
            </ul>
        </div>
        
        <div class="trip-hero-gallery">
            <figure class="main-image">
                <img src="<?php echo htmlspecialchars($viagem['imagem_url'] ?? 'https://via.placeholder.com/800x500.png?text=Imagem+Principal'); ?>" 
                     alt="Preview" id="main-gallery-image">
                
                <div class="image-url-input">
                    <label for="imagem_url">URL da Imagem Principal</label>
                    <input type="text" id="imagem_url" name="imagem_url" 
                           value="<?php echo htmlspecialchars($viagem['imagem_url']); ?>" 
                           placeholder="https://... (link completo da imagem)">
                </div>
            </figure>
            </div>
    </section>

    <section class="section trip-details">
        <div class="details-grid">
            <main class="main-content">
                
                <div class="form-card">
                    <h2>Sobre esta viagem</h2>
                    <textarea id="descricao_longa" name="descricao_longa" class="wysiwyg-editor">
                        <?php echo htmlspecialchars($viagem['descricao_longa']); ?>
                    </textarea>
                </div>
                
                <div class="form-card">
                    <h2>Itinerário detalhado</h2>
                    <textarea id="itinerario_html" name="itinerario_html" class="wysiwyg-editor">
                        <?php echo htmlspecialchars($viagem['itinerario_html']); ?>
                    </textarea>
                </div>

                <div class="form-card">
                    <h2>O que está incluso</h2>
                    <textarea id="incluso_html" name="incluso_html" class="wysiwyg-editor">
                        <?php echo htmlspecialchars($viagem['incluso_html']); ?>
                    </textarea>
                </div>

                <div class="form-card">
                    <h2>Não incluso</h2>
                    <textarea id="nao_incluso_html" name="nao_incluso_html" class="wysiwyg-editor">
                        <?php echo htmlspecialchars($viagem['nao_incluso_html']); ?>
                    </textarea>
                </div>
                
                <div class="form-card">
                    <h2>Hospedagem</h2>
                    <textarea id="hospedagem_html" name="hospedagem_html" class="wysiwyg-editor">
                        <?php echo htmlspecialchars($viagem['hospedagem_html']); ?>
                    </textarea>
                </div>

            </main>

            <aside class="sidebar">
                <div class="booking-box" id="reserva-form">
                    <h3>Filtros e Mapa</h3>
                    
                    <div class="form-group">
                        <label for="continente">Continente</label>
                        <select id="continente" name="continente">
                            <option value="america-sul" <?php echo ($viagem['continente'] == 'america-sul') ? 'selected' : ''; ?>>América do Sul</option>
                            <option value="america-norte" <?php echo ($viagem['continente'] == 'america-norte') ? 'selected' : ''; ?>>América do Norte</option>
                            <option value="europa" <?php echo ($viagem['continente'] == 'europa') ? 'selected' : ''; ?>>Europa</option>
                            <option value="asia" <?php echo ($viagem['continente'] == 'asia') ? 'selected' : ''; ?>>Ásia</option>
                            <option value="africa" <?php echo ($viagem['continente'] == 'africa') ? 'selected' : ''; ?>>África</option>
                            <option value="oceania" <?php echo ($viagem['continente'] == 'oceania') ? 'selected' : ''; ?>>Oceania</option>
                        </select>
                    </div>

                    <div class="form-card" style="padding: 20px; box-shadow: none; border: 1px solid #ddd;">
                        <h4>Locais no Mapa (Pins)</h4>
                        <p style="font-size: 0.9rem; margin-top: -10px; margin-bottom: 15px;">Clique no mapa para adicionar/remover pins.</p>
                        <div id="map-pin-editor"></div>
                        <input type="hidden" name="locations_json" id="locations-json" value="">
                        <ul id="pin-list">
                            </ul>
                    </div>
                    
                </div>
            </aside>
        </div>
    </section>

</form>
<?php
// 5. Inclui o Footer (O do Admin)
include 'templates/footer.php';
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="..."></script>

<script src="https://cdn.tiny.cloud/1/800p6hxm0a1q93lg9wvt3h5sceovfsr56s2x7ssdzmoj6sa0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    // Passa os dados do PHP para o JavaScript
    const baseUrl = '<?php echo BASE_URL; ?>';
    let mapLocations = <?php echo json_encode($locations); ?>;

    document.addEventListener('DOMContentLoaded', () => {

        // --- INICIALIZAÇÃO DO EDITOR WYSIWYG ---
        tinymce.init({
            selector: '.wysiwyg-editor',
            plugins: 'lists link image code table help wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            menubar: false,
            height: 300
        });

        // --- INICIALIZAÇÃO DO MAPA DE PINS ---
        
        // CORREÇÃO 1: Conserta os ícones 404
        // Diz ao Leaflet onde buscar as imagens dos pins
        L.Icon.Default.imagePath = 'https://unpkg.com/leaflet@1.9.4/dist/images/';

        const map = L.map('map-pin-editor').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // CORREÇÃO 2: Conserta o mapa cinza/quebrado
        // Força o mapa a recalcular seu tamanho após o CSS carregar
        setTimeout(() => {
            map.invalidateSize();
        }, 100); // 100ms de delay

        const pinList = document.getElementById('pin-list');
        const locationsInput = document.getElementById('locations-json');
        let markers = {}; 

        // Atualiza o input escondido
        function updateHiddenInput() {
            locationsInput.value = JSON.stringify(mapLocations);
        }

        // Adiciona um pin na tela
        function addPinToUI(loc) {
            const li = document.createElement('li');
            li.id = `pin-${loc.id || loc.temp_id}`;
            li.innerHTML = `
                <span>${loc.nome}</span>
                <button type="button" class="remove-pin" data-id="${loc.id || loc.temp_id}">&times;</button>
            `;
            pinList.appendChild(li);
        }
        
        // Adiciona um pin no mapa
        function addPinToMap(loc) {
            const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
            const markerId = loc.id || loc.temp_id;
            marker.bindPopup(`<b>${loc.nome}</b><br><a href="#" class="remove-pin-map" data-id="${markerId}">Excluir Pin</a>`);
            markers[markerId] = marker;
        }

        // Remove um pin (chamado pela lista ou pelo mapa)
        function removeLocation(id) {
            const li = document.getElementById(`pin-${id}`);
            if (li) li.remove();
            
            if (markers[id]) markers[id].remove();
            delete markers[id];

            mapLocations = mapLocations.filter(loc => (loc.id || loc.temp_id) != id);
            updateHiddenInput();
        }
        
        // Delegação de evento para a lista de pins
        pinList.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-pin')) {
                removeLocation(e.target.dataset.id);
            }
        });

        // Carrega os pins que vieram do banco
        mapLocations.forEach(loc => {
            loc.temp_id = Date.now() + Math.random(); 
            addPinToUI(loc);
            addPinToMap(loc);
        });
        updateHiddenInput();
        
        // Evento de clique no mapa
        map.on('click', (e) => {
            Swal.fire({
                title: 'Nome do Novo Local (Pin)',
                input: 'text',
                inputPlaceholder: 'Ex: Cusco, Peru',
                showCancelButton: true,
                confirmButtonText: 'Adicionar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0b598b',
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const newLoc = {
                        temp_id: Date.now(),
                        nome: result.value,
                        latitude: e.latlng.lat,
                        longitude: e.latlng.lng
                    };
                    
                    mapLocations.push(newLoc);
                    addPinToUI(newLoc);
                    addPinToMap(newLoc);
                    updateHiddenInput();
                }
            });
        });
        
        map.on('popupopen', (e) => {
            const removeBtn = e.popup._container.querySelector('.remove-pin-map');
            if (removeBtn) {
                removeBtn.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    const id = removeBtn.dataset.id;
                    removeLocation(id);
                    map.closePopup();
                });
            }
        });
        
        // Salva o formulário (antes de enviar)
        const form = document.getElementById('viagem-form');
        form.addEventListener('submit', () => {
            tinymce.triggerSave();
            updateHiddenInput();
        });
    });
</script>

</body>
</html>