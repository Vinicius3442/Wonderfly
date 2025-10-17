document.addEventListener('DOMContentLoaded', function() {

    // --- SELETORES GLOBAIS ---
    const carousel = document.querySelector('.carousel');
    const track = document.querySelector('.carousel-track');
    const allSlidesOriginal = Array.from(track.children);
    const nextButton = document.querySelector('.carousel-btn.next');
    const prevButton = document.querySelector('.carousel-btn.prev');
    const filterChips = document.querySelectorAll('.themes .chip');

    let isTransitioning = false; // Previne cliques múltiplos durante a animação

    /**
     * Preenche o carrossel com slides suficientes para criar um loop contínuo.
     * Ele clona os slides filtrados até que a largura total seja bem maior que a área visível.
     * @param {string} filter - A categoria para filtrar.
     */
    function setupCarousel(filter = 'all') {
        const filteredSlides = allSlidesOriginal.filter(slide => {
            return filter === 'all' || slide.dataset.category === filter;
        });

        track.innerHTML = ''; // Limpa o carrossel

        if (filteredSlides.length === 0) {
            nextButton.style.display = 'none';
            prevButton.style.display = 'none';
            return;
        }
        
        nextButton.style.display = 'flex';
        prevButton.style.display = 'flex';
        
        // Garante que o carrossel tenha slides suficientes para o efeito de loop
        const carouselWidth = carousel.offsetWidth;
        let totalWidth = 0;
        let i = 0;
        
        // Adiciona clones até que a largura total dos slides seja pelo menos 3x a do contêiner
        while (totalWidth < carouselWidth * 3) {
            const slide = filteredSlides[i % filteredSlides.length].cloneNode(true);
            track.appendChild(slide);
            totalWidth += slide.offsetWidth + 16; // 16 é o 'gap' do CSS
            i++;
        }
        
        // Posição inicial
        track.style.transition = 'none';
        track.style.transform = 'translateX(0px)';
    }
    
    /**
     * Lógica de movimento da "esteira rolante".
     * @param {string} direction - 'next' ou 'prev'.
     */
    function moveCarousel(direction) {
        if (isTransitioning) return;
        isTransitioning = true;
        
        const slides = Array.from(track.children);
        const slideWidth = slides[0].getBoundingClientRect().width;
        const slideGap = 16; // O 'gap' do CSS

        if (direction === 'next') {
            // Anima o movimento para a esquerda
            track.style.transition = 'transform 0.4s';
            track.style.transform = `translateX(-${slideWidth + slideGap}px)`;
            
            // Quando a animação terminar, move o primeiro slide para o final
            track.addEventListener('transitionend', function onTransitionEnd() {
                track.removeChild(slides[0]); // Remove o slide que saiu da tela
                track.style.transition = 'none'; // Desliga a animação
                track.style.transform = 'translateX(0px)'; // Reseta a posição instantaneamente
                isTransitioning = false;
                track.removeEventListener('transitionend', onTransitionEnd); // Limpa o ouvinte
            });

        } else if (direction === 'prev') {
            // Pega o último slide e o coloca no início
            const lastSlide = slides[slides.length - 1];
            track.removeChild(lastSlide);
            track.insertBefore(lastSlide, slides[0]);
            
            // Move o carrossel para a posição "negativa" do novo slide, sem animação
            track.style.transition = 'none';
            track.style.transform = `translateX(-${slideWidth + slideGap}px)`;

            // Força o navegador a aplicar a mudança e então anima para a posição 0
            setTimeout(() => {
                track.style.transition = 'transform 0.4s';
                track.style.transform = 'translateX(0px)';
            }, 20); // Um pequeno delay para garantir que a transição ocorra

            // Libera para o próximo clique após a animação
            setTimeout(() => {
                isTransitioning = false;
            }, 420);
        }
    }


    // --- EVENT LISTENERS (OUVINTES DE EVENTOS) ---

    nextButton.addEventListener('click', () => moveCarousel('next'));
    prevButton.addEventListener('click', () => moveCarousel('prev'));

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (chip.classList.contains('active')) return;
            document.querySelector('.chip.active').classList.remove('active');
            chip.classList.add('active');
            setupCarousel(chip.dataset.filter);
        });
    });


    // --- INICIALIZAÇÃO ---
    setupCarousel('all');
    window.addEventListener('resize', () => setupCarousel(document.querySelector('.chip.active').dataset.filter));


    // --- FUNCIONALIDADE DO MAPA (sem alterações) ---
    try {
        const centroMapa = [-23.5505, -46.6333];
        const mapa = L.map('mapaAgencias').setView(centroMapa, 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        const agencias = [
            { nome: 'Agência Paulista', lat: -23.5613, lon: -46.6565 },
            { nome: 'Agência Faria Lima', lat: -23.5781, lon: -46.6912 },
            { nome: 'Agência Tatuapé', lat: -23.5413, lon: -46.5794 },
            { nome: 'Agência Morumbi', lat: -23.6022, lon: -46.7041 },
            { nome: 'Agência Santana', lat: -23.5019, lon: -46.626 }
        ];

        agencias.forEach(agencia => {
            L.marker([agencia.lat, agencia.lon])
             .addTo(mapa)
             .bindPopup(`<b>WonderFly ${agencia.nome}</b>`);
        });
    } catch (e) {
        console.error("Erro ao inicializar o mapa:", e);
    }
});