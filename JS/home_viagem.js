document.addEventListener('DOMContentLoaded', () => {

    // --- Seletores Principais ---
    const allCards = document.querySelectorAll('#all-destination-cards .card');
    const allCardsContainer = document.getElementById('all-destination-cards');
    const continentFilter = document.getElementById('continent-filter');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const themeChipsContainer = document.getElementById('theme-chips-container');
    const allThemeChips = themeChipsContainer.querySelectorAll('.chip');
    const verTodosLink = document.getElementById('ver-todos-link');
    const destaqueSection = document.getElementById('destaque-section');

    // Variável para controlar se estamos na visualização de "destaques"
    let featuredViewActive = true;

    /**
     * GOAL 2: Destaques Dinâmicos
     * Esta função seleciona aleatoriamente 3 cards para serem os "destaques".
     */
    function initializeFeaturedView() {
        // Converte NodeList para Array, embaralha e pega os 3 primeiros
        const shuffled = Array.from(allCards).sort(() => 0.5 - Math.random());
        const featuredCards = shuffled.slice(0, 3);

        // Esconde todos os cards primeiro
        allCards.forEach(card => card.style.display = 'none');

        // Mostra apenas os cards "em destaque"
        featuredCards.forEach(card => card.style.display = 'block');
        
        featuredViewActive = true;
    }

    /**
     * GOAL 1 & 4: Sistema de Filtro Robusto
     * Esta é a função principal que filtra todos os cards visíveis.
     */
    function filterDestinations() {
        const continentValue = continentFilter.value;
        const themeValue = themeChipsContainer.querySelector('.chip.active').dataset.filter;
        // Normaliza o texto da pesquisa
        const searchValue = searchInput.value.toLowerCase().trim();
        const searchTerms = searchValue.split(' ').filter(term => term.length > 0);

        let hasVisibleCards = false;

        allCards.forEach(card => {
            const cardContinent = card.dataset.continent;
            const cardCategories = card.dataset.category.split(' '); // Ex: ["aventura", "historia"]
            const cardKeywords = card.dataset.keywords.toLowerCase();

            // 1. Verifica filtro de Continente
            const continentMatch = (continentValue === 'all' || cardContinent === continentValue);

            // 2. Verifica filtro de Tema
            const themeMatch = (themeValue === 'all' || cardCategories.includes(themeValue));

            // 3. Verifica filtro de Pesquisa (todas as palavras-chave devem estar presentes)
            let searchMatch = true;
            if (searchTerms.length > 0) {
                searchMatch = searchTerms.every(term => cardKeywords.includes(term));
            }

            // O card só é exibido se TODAS as condições forem verdadeiras
            if (continentMatch && themeMatch && searchMatch) {
                card.style.display = 'block';
                hasVisibleCards = true;
            } else {
                card.style.display = 'none';
            }
        });

        // (Opcional) Mostrar uma mensagem se nenhum card for encontrado
        // Você pode adicionar um <p id="no-results-message"> no seu HTML
    }

    /**
     * Função de transição: Sai da visualização "destaques" para a "todos"
     * e aplica os filtros.
     */
    function activateFullFilterView() {
        if (featuredViewActive) {
            // Revela todos os cards para que a função de filtro possa avaliá-los
            allCards.forEach(card => card.style.display = 'block');
            featuredViewActive = false;

            // Opcional: esconde o título "Roteiros em Destaque"
            if (destaqueSection) {
                destaqueSection.style.display = 'none';
            }
        }
        // Roda a lógica de filtro
        filterDestinations();
    }


    // --- Event Listeners para Filtros ---

    // 1. Chips de Tema
    allThemeChips.forEach(chip => {
        chip.addEventListener('click', () => {
            // Atualiza a classe 'active'
            themeChipsContainer.querySelector('.chip.active').classList.remove('active');
            chip.classList.add('active');
            
            // Ativa a visualização completa e filtra
            activateFullFilterView();
        });
    });

    // 2. Botão de Pesquisar
    searchButton.addEventListener('click', activateFullFilterView);

    // 3. Pesquisa em tempo real (ao digitar)
    searchInput.addEventListener('input', activateFullFilterView);

    // 4. Filtro de Continente
    continentFilter.addEventListener('change', activateFullFilterView);


    /**
     * GOAL 3: Botão "Ver todos"
     * O link "Ver todos" agora se torna um botão funcional.
     */
    verTodosLink.addEventListener('click', (e) => {
        e.preventDefault(); // Impede o comportamento padrão do link

        // 1. Reseta todos os filtros para o padrão
        continentFilter.value = 'all';
        searchInput.value = '';
        themeChipsContainer.querySelector('.chip.active').classList.remove('active');
        themeChipsContainer.querySelector('.chip[data-filter="all"]').classList.add('active');

        // 2. Ativa a visualização completa (que mostrará todos, pois os filtros estão resetados)
        activateFullFilterView();

        // 3. Rola suavemente até o contêiner dos cards
        allCardsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // --- Inicialização da Página ---
    // Começa mostrando apenas os destaques dinâmicos
    initializeFeaturedView();


    // --- Funcionalidades Bônus (para a página ficar completa) ---

    // Botão "Voltar ao Topo"
    const backToTopButton = document.getElementById('back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Menu Hambúrguer (Mobile)
    const burgerMenu = document.getElementById('burger-menu');
    const header = document.getElementById('main-header');
    if (burgerMenu && header) {
        burgerMenu.addEventListener('click', () => {
            header.classList.toggle('nav-open'); // Você precisará de CSS para .nav-open
        });
    }

    // Formulário de Newsletter
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterEmail = document.getElementById('newsletter-email');
    const newsletterMessage = document.getElementById('newsletter-message');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterEmail.value;
            
            if (email && email.includes('@')) {
                newsletterMessage.textContent = 'Obrigado por se inscrever!';
                newsletterMessage.className = 'newsletter-message success';
                newsletterEmail.value = '';
            } else {
                newsletterMessage.textContent = 'Por favor, insira um e-mail válido.';
                newsletterMessage.className = 'newsletter-message error';
            }
            // Limpa a mensagem após 3 segundos
            setTimeout(() => {
                newsletterMessage.textContent = '';
                newsletterMessage.className = 'newsletter-message';
            }, 3000);
        });
    }

    // Inicialização do Mapa (Leaflet)
    // O seu HTML já chama o Leaflet, então vamos iniciá-lo.
    const mapElement = document.getElementById('mapaDestinos');
    if (mapElement && typeof L !== 'undefined') {
         // Coordenadas [lat, long] e zoom inicial
         const map = L.map('mapaDestinos').setView([20, 0], 2); // Visão global

         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
         }).addTo(map);

         // Adiciona marcadores (baseados nos seus cards)
         // Você precisará encontrar as coordenadas corretas
         const destinations = [
            { name: "Trilhas dos Incas - Peru", coords: [-13.163, -72.545] },
            { name: "Sabores da Itália Rural", coords: [43.771, 11.254] },
            { name: "Templos Místicos da Tailândia", coords: [13.756, 100.501] },
            { name: "Aurora Boreal na Islândia", coords: [64.963, -19.020] },
            { name: "Patagônia Selvagem - Argentina", coords: [-50.5, -72.5] },
            { name: "Retiro Zen no Japão", coords: [35.011, 135.768] },
            { name: "Grécia Antiga e Ilhas", coords: [37.983, 23.727] },
            { name: "Tour Culinário na Cidade do México", coords: [19.432, -99.133] },
            { name: "Safari Fotográfico no Quênia", coords: [-1.292, 36.821] },
            { name: "Praias Paradisíacas das Maldivas", coords: [3.202, 73.220] }
         ];

         destinations.forEach(dest => {
            L.marker(dest.coords).addTo(map).bindPopup(dest.name);
         });
    }

});