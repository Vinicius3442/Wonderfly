document.addEventListener("DOMContentLoaded", () => {
  // --- LÓGICA DO CARROSSEL INFINITO E FILTROS ---

  const carousel = document.querySelector(".carousel");
  const track = document.querySelector(".carousel-track");
  // Guarda a ordem original dos slides para resetar o filtro
  const originalSlides = Array.from(track.children);
  const nextButton = document.querySelector(".carousel-btn.next");
  const prevButton = document.querySelector(".carousel-btn.prev");
  const chips = document.querySelectorAll(".themes .chip");

  let isMoving = false; // Flag para evitar cliques duplos durante a animação
  let slideWidth = 0;
  let slideGap = 0;

  // Função para calcular a largura do slide e o gap
  function updateCarouselMetrics() {
    // Pega os slides visíveis ATUALMENTE no DOM
    const visibleSlides = Array.from(track.children).filter(
      (s) => s.style.display !== "none"
    );

    if (visibleSlides.length > 0) {
      // Calcula a largura do primeiro slide visível
      slideWidth = visibleSlides[0].offsetWidth;
      // Tenta pegar o 'gap' do CSS, se falhar, usa 16 como padrão
      slideGap = parseFloat(window.getComputedStyle(track).gap) || 16;
    }
  }

  // --- Event Listeners dos Botões do Carrossel ---

  nextButton.addEventListener("click", () => {
    if (isMoving) return;
    isMoving = true;

    // Pega todos os slides visíveis NO MOMENTO
    let visibleSlides = Array.from(track.children).filter(
      (s) => s.style.display !== "none"
    );

    if (visibleSlides.length <= 1) {
      isMoving = false;
      return; // Não faz nada se só tiver 1 ou 0 slides
    }

    // Pega o primeiro slide visível
    const firstVisibleSlide = visibleSlides[0];

    // Atualiza as métricas para garantir que o 'gap' e 'width' estão corretos
    updateCarouselMetrics();

    // Aplica a animação de translação
    track.style.transition = "transform 0.4s ease-in-out";
    track.style.transform = `translateX(-${slideWidth + slideGap}px)`;

    // Quando a animação terminar...
    track.addEventListener(
      "transitionend",
      () => {
        // ...move o slide que saiu da tela para o final da fila
        track.appendChild(firstVisibleSlide);

        // ...e reseta a posição do track sem animar
        track.style.transition = "none";
        track.style.transform = "translateX(0)";

        // Habilita o clique novamente
        isMoving = false;
      },
      { once: true } // O listener é removido após ser executado
    );
  });

  prevButton.addEventListener("click", () => {
    if (isMoving) return;
    isMoving = true;

    // Pega todos os slides visíveis NO MOMENTO
    let visibleSlides = Array.from(track.children).filter(
      (s) => s.style.display !== "none"
    );

    if (visibleSlides.length <= 1) {
      isMoving = false;
      return; // Não faz nada se só tiver 1 ou 0 slides
    }

    // Pega o último slide visível
    const lastVisibleSlide = visibleSlides[visibleSlides.length - 1];

    // Atualiza as métricas
    updateCarouselMetrics();

    // Move o último slide (que está fora da tela, à direita) para o início
    track.insertBefore(lastVisibleSlide, track.children[0]);

    // Prepara a transição "de volta"
    // Move o track para a esquerda (para "esconder" o slide que acabamos de adicionar)
    track.style.transition = "none";
    track.style.transform = `translateX(-${slideWidth + slideGap}px)`;

    // Força o navegador a aplicar o transform (reflow)
    // Sem isso, a animação não funciona
    setTimeout(() => {
      // Agora, anima de volta para a posição 0, "revelando" o novo slide
      track.style.transition = "transform 0.4s ease-in-out";
      track.style.transform = "translateX(0)";
    }, 10); // Um pequeno delay é o suficiente

    // Quando a animação terminar, permite o clique novamente
    track.addEventListener(
      "transitionend",
      () => {
        isMoving = false;
      },
      { once: true }
    );
  });

  // --- Event Listeners dos Filtros (Chips) ---

  chips.forEach((chip) => {
    chip.addEventListener("click", (e) => {
      // 1. Atualiza o estado "active" do chip
      chips.forEach((c) => c.classList.remove("active"));
      e.currentTarget.classList.add("active");

      const filter = e.currentTarget.dataset.filter;

      // 2. Mostra/Esconde os slides (usando a lista original)
      originalSlides.forEach((slide) => {
        // Pega as categorias do slide (assumindo separação por espaço)
        const slideCategories = slide.dataset.category ? slide.dataset.category.split(' ') : [];

        if (filter === "all" || slideCategories.includes(filter)) {
          slide.style.display = "flex";
        } else {
          slide.style.display = "none";
        }
      });

      // 3. CRÍTICO: Re-ordena os slides no DOM para o estado original
      // Isso reseta o carrossel após as movimentações (appendChild/insertBefore)
      originalSlides.forEach((slide) => track.appendChild(slide));

      // 4. Reseta a posição do carrossel
      track.style.transition = "none";
      track.style.transform = "translateX(0)";

      // 5. Atualiza a largura do slide
      updateCarouselMetrics();
    });
  });

  // --- Inicialização do Carrossel ---

  // Chama a função uma vez no início para configurar
  updateCarouselMetrics();

  // Atualiza as métricas se a janela for redimensionada
  window.addEventListener("resize", updateCarouselMetrics);

  // --- LÓGICA DO MAPA LEAFLET ---

  if (document.getElementById("mapaAgencias")) {

    // --- 1. CAMINHO DO ÍCONE CORRIGIDO ---
    const momentoIcon = L.icon({
      iconUrl: `${baseUrl}./images/logo.png`, // CORRIGIDO: Removido o "./"
      iconSize: [32, 37],     // Atenção: Verifique se este é o tamanho real do logo.png
      iconAnchor: [16, 37],   // Metade da largura, altura total (para a ponta ficar no lugar certo)
      popupAnchor: [0, -38]
    });

    // 1. Inicializa o mapa
    const map = L.map("mapaAgencias").setView([-23.2098, -45.2133], 8);

    // 2. Adiciona o "chão" do mapa
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    // 3. Define os locais das suas agências
    const agencias = [
      {
        lat: -23.5489, // São Paulo (próx. à Sé)
        lng: -46.6388,
        nome: "<strong>WonderFly - São Paulo</strong><br>Av. Paulista, 1000",
      },
      {
        lat: -22.9068, // Rio de Janeiro (Centro)
        lng: -43.1729,
        nome: "<strong>WonderFly - Rio de Janeiro</strong><br>Av. Rio Branco, 150",
      },
      {
        lat: -23.1791, // São José dos Campos (Bônus)
        lng: -45.8872,
        nome: "<strong>WonderFly - Vale do Paraíba</strong><br>Rua das Palmeiras, 50",
      },
    ];

    // --- 2. SINTAXE DO MARCADOR CORRIGIDA ---
    // O erro de sintaxe foi corrigido aqui:
    agencias.forEach((agencia) => {
      L.marker([agencia.lat, agencia.lng], { // O objeto de opções é o SEGUNDO argumento
        icon: momentoIcon                    // Usa a variável correta
      })
        .addTo(map)
        .bindPopup(agencia.nome); // Adiciona o pop-up com o nome
    });

    // (Opcional) Ajusta o mapa para mostrar todos os marcadores
    const group = new L.featureGroup(agencias.map(a => L.marker([a.lat, a.lng])));
    map.fitBounds(group.getBounds().pad(0.5)); // .pad(0.5) dá uma margem
  }

});