/* =============================================
   ARQUIVO: home_viagem.js
   Lógica para a página de listagem de viagens
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

  // ===============================================
  // 1. MAPA DE DESTINOS
  // ===============================================
  const mapElement = document.getElementById('mapaDestinos');

  if (mapElement && typeof allTrips !== 'undefined' && Array.isArray(allTrips)) {

    // Inicializa o mapa (centralizado em uma visão global ou no primeiro destino)
    const map = L.map('mapaDestinos').setView([20, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const markers = L.featureGroup();

    allTrips.forEach(trip => {
      // Verifica se tem coordenadas (assumindo que 'latitude' e 'longitude' existem no objeto)
      // Se não existirem no objeto principal, talvez precisemos buscar de algum lugar.
      // Mas o PHP fez "SELECT * FROM viagens". Vamos assumir que a tabela viagens tem lat/lng
      // OU que precisamos pegar do primeiro local associado.
      // Como o user não especificou, vamos tentar usar lat/lng direto se existir,
      // ou pular se não tiver.

      // NOTA: Se a tabela 'viagens' não tem lat/lng direto, isso pode falhar.
      // Mas vamos assumir que tem ou que o PHP já preparou isso.
      // Se não tiver, o marcador não será adicionado.

      if (trip.latitude && trip.longitude) {
        const marker = L.marker([trip.latitude, trip.longitude]);

        // Popup com imagem e link
        const popupContent = `
                    <div style="text-align:center; width: 150px;">
                        <img src="${trip.imagem_url}" style="width:100%; height:100px; object-fit:cover; border-radius:4px; margin-bottom:8px;">
                        <h4 style="margin:0; font-size:1rem; color:#0b598b;">${trip.titulo}</h4>
                        <p style="margin:5px 0; font-size:0.85rem;">${trip.continente}</p>
                        <a href="${baseUrl}Viagem/viagem.php?id=${trip.id}" style="display:inline-block; margin-top:5px; color:#f07913; font-weight:600; text-decoration:none;">Ver Detalhes</a>
                    </div>
                `;

        marker.bindPopup(popupContent);
        markers.addLayer(marker);
      }
    });

    if (markers.getLayers().length > 0) {
      markers.addTo(map);
      map.fitBounds(markers.getBounds().pad(0.1));
    }
  }


  // ===============================================
  // 2. FILTROS E BUSCA
  // ===============================================
  const searchInput = document.getElementById('search-input');
  const searchBtn = document.getElementById('search-button');
  const continentFilter = document.getElementById('continent-filter');
  const themeChips = document.querySelectorAll('.chip');
  const allCards = document.querySelectorAll('.card');
  const noResultsMsg = document.querySelector('.grid.cards p'); // Mensagem de "nenhuma viagem"

  function filterTrips() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedContinent = continentFilter.value;
    const activeChip = document.querySelector('.chip.active');
    const selectedTheme = activeChip ? activeChip.dataset.filter : 'all';

    let visibleCount = 0;

    allCards.forEach(card => {
      const title = card.querySelector('h3').textContent.toLowerCase();
      const continent = card.dataset.continent; // ex: 'America do Sul'
      const categories = card.dataset.category.toLowerCase(); // ex: 'Aventura, Natureza'
      const keywords = card.dataset.keywords ? card.dataset.keywords.toLowerCase() : '';

      // Verifica Texto (Título ou Keywords)
      const matchesSearch = title.includes(searchTerm) || keywords.includes(searchTerm);

      // Verifica Continente
      // Normaliza strings para comparação (remove acentos se necessário, mas aqui vamos simples)
      let matchesContinent = false;
      if (selectedContinent === 'all') {
        matchesContinent = true;
      } else {
        // Mapeamento simples ou includes
        // O value do select é ex: 'america-sul', 'europa'
        // O dataset é ex: 'América do Sul', 'Europa'
        const normContinent = continent.toLowerCase().replace(/é/g, 'e').replace(/á/g, 'a').replace(/ /g, '-');
        matchesContinent = normContinent.includes(selectedContinent);
      }

      // Verifica Tema
      let matchesTheme = false;
      if (selectedTheme === 'all') {
        matchesTheme = true;
      } else {
        matchesTheme = categories.includes(selectedTheme);
      }

      if (matchesSearch && matchesContinent && matchesTheme) {
        card.style.display = 'flex'; // Restaura display flex (definido no CSS)
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Mostra/Esconde mensagem de "sem resultados"
    // Se não existir a msg no HTML (pq tinha viagens no PHP), precisamos criar ou ignorar
    // O PHP renderiza <p> se empty($viagens). Se não empty, não tem <p>.
    // Vamos assumir que se não tiver <p>, não mostramos nada por enquanto ou criamos dinamicamente.
  }

  // Event Listeners
  if (searchBtn) searchBtn.addEventListener('click', filterTrips);
  if (searchInput) {
    searchInput.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') filterTrips();
    });
  }
  if (continentFilter) continentFilter.addEventListener('change', filterTrips);

  themeChips.forEach(chip => {
    chip.addEventListener('click', () => {
      // Remove active de todos
      themeChips.forEach(c => c.classList.remove('active'));
      // Adiciona ao clicado
      chip.classList.add('active');
      filterTrips();
    });
  });


  // ===============================================
  // 3. VOLTAR AO TOPO
  // ===============================================
  const backToTopButton = document.getElementById("back-to-top");
  if (backToTopButton) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 300) {
        backToTopButton.classList.add("show");
      } else {
        backToTopButton.classList.remove("show");
      }
    });

    backToTopButton.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

});