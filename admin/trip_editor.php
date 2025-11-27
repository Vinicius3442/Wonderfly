<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Viagem - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <!-- Correct Trip Page CSS for Preview -->
    <link rel="stylesheet" href="../CSS/viagempage.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* Override some global styles that might conflict with admin */
        .editor-preview {
            /* Reset font if needed, though admin.css sets Poppins */
        }
        
        .editor-container {
            display: flex;
            gap: 20px;
            height: calc(100vh - 100px);
            position: relative; /* For fullscreen absolute positioning */
        }
        
        /* Fullscreen Styles */
        .editor-container.fullscreen .editor-form {
            display: none;
        }
        .editor-container.fullscreen .editor-preview {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            border-radius: 0;
            padding: 40px;
        }
        .fullscreen-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 100;
            background: rgba(0,0,0,0.6);
            color: #fff;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }
        .fullscreen-btn:hover {
            background: rgba(0,0,0,0.8);
        }

        .editor-form {
            flex: 1;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .editor-preview {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            overflow-y: auto;
            color: #222;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .form-group label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .form-group input, .form-group textarea, .form-group select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 10px;
            border-radius: 8px;
            color: var(--text-light);
            font-family: inherit;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row .form-group {
            flex: 1;
        }
        
        .builder-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 10px;
        }
        .builder-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 15px;
            border-radius: 8px;
            position: relative;
        }
        .builder-item .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: #ff4d4d;
            cursor: pointer;
        }
        .btn-add-item {
            background: rgba(255, 255, 255, 0.1);
            border: 1px dashed var(--glass-border);
            color: var(--text-muted);
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        .btn-add-item:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-light);
        }
        
        /* Map Section in Form */
        #mapEditor {
            height: 300px;
            border-radius: 8px;
            margin-top: 10px;
            z-index: 1; /* Ensure it doesn't overlap weirdly */
        }
        .locations-list {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .location-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }
        .location-item button {
            background: transparent;
            border: none;
            color: #ff4d4d;
            cursor: pointer;
        }

        /* Preview Styles (Mimicking Home Card) */
        .preview-card {
            margin: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
            max-width: 400px;
            align-self: center;
        }
        .preview-img {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .preview-body {
            padding: 20px;
        }
        .preview-body h3 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            color: #333;
        }
        .preview-body p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        .preview-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #555;
            font-weight: 600;
        }
        .preview-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 10;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../assets/img/logo.png" alt="WonderFly Logo" style="height: 40px; margin-right: 10px;">
            <span>WonderFly</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            <a href="blog.php" class="nav-item">
                <i class="ri-article-line"></i> Blog
            </a>
            <a href="#" class="nav-item">
                <i class="ri-discuss-line"></i> Fórum
            </a>
            <a href="users.php" class="nav-item">
                <i class="ri-user-line"></i> Usuários
            </a>
            <a href="trips.php" class="nav-item active">
                <i class="ri-map-pin-line"></i> Viagens
            </a>
            <a href="../index.php" class="nav-item">
                <i class="ri-arrow-left-line"></i> Voltar ao Site
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header-bar">
            <div class="header-title">
                <h1>Editor de Viagem</h1>
            </div>
            <div class="action-buttons">
                <button class="btn-export" onclick="history.back()">Cancelar</button>
                <button class="btn-add" onclick="saveTrip()">Salvar Viagem</button>
            </div>
        </div>

        <div class="editor-container">
            <!-- Form -->
            <div class="editor-form">
                <div class="form-group">
                    <label>Título</label>
                    <input type="text" id="tripTitle" placeholder="Ex: Trilhas dos Incas">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Preço (R$)</label>
                        <input type="number" id="tripPrice" step="0.01" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Duração</label>
                        <input type="text" id="tripDuration" placeholder="Ex: 8 dias">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Continente</label>
                        <select id="tripContinent">
                            <option value="america-sul">América do Sul</option>
                            <option value="europa">Europa</option>
                            <option value="asia">Ásia</option>
                            <option value="africa">África</option>
                            <option value="america-norte">América do Norte</option>
                            <option value="oceania">Oceania</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Categorias (separadas por espaço)</label>
                        <input type="text" id="tripCategories" placeholder="aventura historia">
                    </div>
                </div>

                <div class="form-group">
                    <label>URL da Imagem</label>
                    <input type="text" id="tripImage" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label>Descrição Curta</label>
                    <textarea id="tripShortDesc" style="min-height: 80px;" placeholder="Breve descrição para o card..."></textarea>
                </div>

                <div class="form-group">
                    <label>Descrição Longa (Intro)</label>
                    <textarea id="tripLongDesc" placeholder="<p>Introdução da viagem...</p>"></textarea>
                </div>

                <!-- Itinerary Builder -->
                <div class="form-group">
                    <label>Itinerário Detalhado</label>
                    <div id="itineraryList" class="builder-list"></div>
                    <button class="btn-add-item" onclick="addItineraryDay()">+ Adicionar Dia</button>
                </div>

                <!-- Included Items Builder -->
                <div class="form-group">
                    <label>O que está incluso</label>
                    <div id="includedList" class="builder-list"></div>
                    <button class="btn-add-item" onclick="addIncludedItem()">+ Adicionar Item</button>
                </div>

                <!-- Not Included Items Builder -->
                <div class="form-group">
                    <label>Não incluso</label>
                    <div id="notIncludedList" class="builder-list"></div>
                    <button class="btn-add-item" onclick="addNotIncludedItem()">+ Adicionar Item</button>
                </div>

                <!-- Accommodation Builder -->
                <div class="form-group">
                    <label>Hospedagem</label>
                    <div id="accommodationList" class="builder-list"></div>
                    <button class="btn-add-item" onclick="addAccommodation()">+ Adicionar Hotel</button>
                </div>

                <!-- Locations Manager -->
                <div class="form-group">
                    <label>Localizações (Clique no mapa para adicionar)</label>
                    <div id="mapEditor"></div>
                    <div class="locations-list" id="locationsList">
                        <!-- Added locations will appear here -->
                    </div>
                </div>

            </div>

            <!-- Live Preview -->
            <div class="editor-preview" id="previewContainer">
                <button class="fullscreen-btn" onclick="toggleFullscreen()" title="Tela Cheia">
                    <i class="ri-fullscreen-line"></i>
                </button>
                <span class="preview-label">Card Preview</span>
                
                <div class="preview-content-wrapper">
                    <!-- Trip Hero Section -->
                    <section class="trip-hero" id="previewHero" style="min-height: auto; padding-top: 40px;">
                        <div class="trip-hero-content">
                            <span class="badge" id="previewCategory">Categoria</span>
                            <h1 id="previewTitle">Título da Viagem</h1>
                            <p id="previewShortDesc">A descrição curta aparecerá aqui...</p>
                            
                            <ul class="trip-meta">
                                <li><i class="ri-time-line"></i> <span id="previewDuration">0 dias</span></li>
                                <li><i class="ri-wallet-3-line"></i> <span id="previewPrice">R$ 0,00</span></li>
                                <li><i class="ri-map-pin-line"></i> <span id="previewContinent">Continente</span></li>
                            </ul>
                            <a class="btn primary lg" href="#"><i class="ri-check-line"></i> Reservar Agora</a>
                        </div>
                        
                        <div class="trip-hero-gallery">
                            <figure class="main-image">
                                <img src="../images/placeholder.jpg" alt="Trip Image" id="previewMainImage">
                            </figure>
                        </div>
                    </section>
                </div>

                <div style="padding: 20px;">
                    <h4>Preview de Conteúdo (HTML)</h4>
                    <div id="previewLongDesc" style="font-size: 0.9rem; color: #444;"></div>
                </div>
            </div>
        </div>

    </main>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="js/trip_editor.js"></script>
</body>
</html>
