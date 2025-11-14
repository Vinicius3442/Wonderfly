<?php
// 1. Define o 'slug' e 'título'
$page_slug = 'gerir_viagens';
$page_title = 'Editor de Viagem';

// 2. Inclui o Guardião
include 'admin_guardian.php';

// 3. Lógica de Edição vs. Criação
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
    // Se está editando, busca os dados da viagem
    $page_title = 'Editar Viagem';
    
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

<style>
    .editor-grid {
        display: grid;
        grid-template-columns: 2fr 1fr; /* Coluna principal 2/3, coluna lateral 1/3 */
        gap: 25px;
    }
    .main-column { display: flex; flex-direction: column; gap: 20px; }
    .sidebar-column { display: flex; flex-direction: column; gap: 20px; }
    
    /* Adapta o .content-card para o formulário */
    .form-card {
        background-color: #fff;
        border-radius: 10px;
        border: 1px solid var(--color-border);
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .form-card h2 {
        margin-top: 0;
        font-size: 1.3rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-family: var(--font-main);
        font-size: 0.95rem;
    }
    .form-group textarea {
        min-height: 80px;
    }
    
    /* Mapa de Pins */
    #map-pin-editor {
        height: 300px;
        width: 100%;
        border-radius: 6px;
        z-index: 1;
        cursor: crosshair;
    }
    #pin-list {
        list-style: none;
        padding: 0;
        margin-top: 10px;
    }
    #pin-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px;
        background: #f4f7fa;
        border-radius: 4px;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    #pin-list li button {
        background: none;
        border: none;
        color: #c0392b;
        cursor: pointer;
        font-size: 1rem;
    }
</style>

<form id="viagem-form" action="<?php echo BASE_URL; ?>api/admin_salvar_viagem.php" method="POST">
    
    <?php if ($is_editing): ?>
        <input type="hidden" name="viagem_id" value="<?php echo $viagem['id']; ?>">
    <?php endif; ?>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><?php echo $page_title; ?></h1>
        <button type="submit" class="btn primary" style="font-size: 1rem; padding: 12px 20px;">
            <i class="ri-save-line"></i> Salvar Viagem
        </button>
    </div>

    <div class="editor-grid">
        <div class="main-column">
            
            <div class="form-card">
                <h2>Dados Principais</h2>
                <div class="form-group">
                    <label for="titulo">Título da Viagem</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($viagem['titulo']); ?>" placeholder="Ex: Trilhas dos Incas - Peru" required>
                </div>
                <div class="form-group">
                    <label for="descricao_curta">Descrição Curta (para o card)</label>
                    <textarea id="descricao_curta" name="descricao_curta" placeholder="Aventure-se pelos Andes, descubra Machu Picchu..."><?php echo htmlspecialchars($viagem['descricao_curta']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="imagem_url">URL da Imagem Principal (do card)</label>
                    <input type="text" id="imagem_url" name="imagem_url" value="<?php echo htmlspecialchars($viagem['imagem_url']); ?>" placeholder="https://... (link completo da imagem)">
                </div>
            </div>

            <div class="form-card">
                <h2>Sobre esta Viagem (Descrição Longa)</h2>
                <textarea id="descricao_longa" name="descricao_longa" class="wysiwyg-editor">
                    <?php echo htmlspecialchars($viagem['descricao_longa']); ?>
                </textarea>
            </div>
            
            <div class="form-card">
                <h2>Itinerário Detalhado</h2>
                <textarea id="itinerario_html" name="itinerario_html" class="wysiwyg-editor">
                    <?php echo htmlspecialchars($viagem['itinerario_html']); ?>
                </textarea>
            </div>

            <div class="form-card">
                <h2>O que está Incluso</h2>
                <textarea id="incluso_html" name="incluso_html" class="wysiwyg-editor">
                    <?php echo htmlspecialchars($viagem['incluso_html']); ?>
                </textarea>
            </div>
            
            <div class="form-card">
                <h2>O que NÃO está Incluso</h2>
                <textarea id="nao_incluso_html" name="nao_incluso_html" class="wysiwyg-editor">
                    <?php echo htmlspecialchars($viagem['nao_incluso_html']); ?>
                </textarea>
            </div>
            
            <div class="form-card">
                <h2>Hospedagem Selecionada</h2>
                <textarea id="hospedagem_html" name="hospedagem_html" class="wysiwyg-editor">
                    <?php echo htmlspecialchars($viagem['hospedagem_html']); ?>
                </textarea>
            </div>

        </div>

        <div class="sidebar-column">
            
            <div class="form-card">
                <h2>Filtros e Preço</h2>
                <div class="form-group">
                    <label for="preco">Preço (Ex: 4100.00)</label>
                    <input type="number" step="0.01" id="preco" name="preco" value="<?php echo htmlspecialchars($viagem['preco']); ?>" placeholder="4100.00" required>
                </div>
                <div class="form-group">
                    <label for="duracao">Duração</label>
                    <input type="text" id="duracao" name="duracao" value="<?php echo htmlspecialchars($viagem['duracao']); ?>" placeholder="Ex: 8 dias" required>
                </div>
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
                <div class="form-group">
                    <label for="categorias">Categorias (separadas por espaço)</label>
                    <input type="text" id="categorias" name="categorias" value="<?php echo htmlspecialchars($viagem['categorias']); ?>" placeholder="aventura historia" required>
                </div>
                <div class="form-group">
                    <label for="keywords">Palavras-chave (para busca)</label>
                    <textarea id="keywords" name="keywords" placeholder="peru incas machu picchu..."><?php echo htmlspecialchars($viagem['keywords']); ?></textarea>
                </div>
            </div>

            <div class="form-card">
                <h2>Locais no Mapa (Pins)</h2>
                <p style="font-size: 0.9rem; margin-top: -15px; margin-bottom: 15px;">Clique no mapa para adicionar um pin. Clique no pin para removê-lo.</p>
                <div id="map-pin-editor"></div>
                <input type="hidden" name="locations_json" id="locations-json" value="">
                
                <ul id="pin-list">
                    </ul>
            </div>
        </div>
    </div>
</form>

<?php
// 5. Inclui o Footer
include 'templates/footer.php';
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="..."></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="..."/>

<script src="https://cdn.tiny.cloud/1/800p6hxm0a1q93lg9wvt3h5sceovfsr56s2x7ssdzmoj6sa0/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    // Passa os dados do PHP para o JavaScript
    const baseUrl = '<?php echo BASE_URL; ?>';
    // Converte os locais do PHP para um objeto JS
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
        const map = L.map('map-pin-editor').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const pinList = document.getElementById('pin-list');
        const locationsInput = document.getElementById('locations-json');
        let markers = {}; // Objeto para guardar os marcadores

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
                <button type="button" class="remove-pin">&times;</button>
            `;
            pinList.appendChild(li);

            // Adiciona evento ao botão de remover
            li.querySelector('.remove-pin').addEventListener('click', () => {
                removeLocation(loc.id || loc.temp_id);
            });
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
            // Remove da lista
            const li = document.getElementById(`pin-${id}`);
            if (li) li.remove();
            
            // Remove do mapa
            if (markers[id]) markers[id].remove();
            delete markers[id];

            // Remove do array de dados
            mapLocations = mapLocations.filter(loc => (loc.id || loc.temp_id) != id);
            updateHiddenInput();
        }

        // Carrega os pins que vieram do banco
        mapLocations.forEach(loc => {
            loc.temp_id = Date.now() + Math.random(); // Dá um ID temporário
            addPinToUI(loc);
            addPinToMap(loc);
        });
        updateHiddenInput(); // Salva o estado inicial
        

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
        
        // Evento para remover pelo popup do mapa
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
            // Garante que os editores WYSIWYG estão salvos
            tinymce.triggerSave();
            // Garante que os pins estão salvos
            updateHiddenInput();
        });
    });
</script>

</body>
</html>