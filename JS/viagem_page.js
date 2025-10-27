document.addEventListener("DOMContentLoaded", () => {
  // --- Elementos Comuns (Nav, Newsletter, Topo) ---
  const backToTopButton = document.getElementById("back-to-top");
  const burgerMenu = document.getElementById("burger");
  const mainNav = document.getElementById("nav");
  const newsletterForm = document.getElementById("newsletter-form-page");
  const newsletterEmail = document.getElementById("newsletter-email-page");
  const newsletterMessage = document.getElementById("newsletter-message-page");

  // --- Elementos Específicos da Página ---
  const mainGalleryImage = document.getElementById("main-gallery-image");
  const thumbnailImages = document.querySelectorAll(".thumbnail-images img");
  const bookingForm = document.getElementById("booking-form-page");
  const bookingMessage = document.getElementById("booking-message");

  // --- 1. LÓGICA DA GALERIA DE IMAGENS ---
  function initGallery() {
    if (!mainGalleryImage || thumbnailImages.length === 0) return;

    thumbnailImages.forEach((thumb) => {
      thumb.addEventListener("click", () => {
        // Pega o src da miniatura clicada
        const newSrc = thumb.src;
        // Pega o alt da miniatura clicada
        const newAlt = thumb.alt;

        // Aplica na imagem principal
        mainGalleryImage.src = newSrc;
        mainGalleryImage.alt = newAlt;

        // (Opcional) Adiciona um efeito de fade
        mainGalleryImage.style.opacity = 0;
        setTimeout(() => {
          mainGalleryImage.style.opacity = 1;
        }, 100); // transição rápida
      });

      // (Opcional) Adiciona um estilo ao cursor
      thumb.style.cursor = "pointer";
    });
    
    // Adiciona transição na imagem principal
    mainGalleryImage.style.transition = "opacity 0.2s ease-in-out";
  }

  // --- 2. LÓGICA DO MAPA (PÁGINA ÚNICA) ---
  function initSingleTripMap() {
    const mapDiv = document.getElementById("mapaDestinoUnico");
    if (mapDiv) {
      // Coordenadas para o Irã (Teerã, Isfahan, Shiraz)
      const locations = [
        { lat: 35.6892, lng: 51.3890, nome: "Teerã" },
        { lat: 32.6546, lng: 51.6680, nome: "Isfahan" },
        { lat: 29.6101, lng: 52.5311, nome: "Shiraz" }
      ];

      // Encontra o centro (média)
      const centerLat = locations.reduce((sum, loc) => sum + loc.lat, 0) / locations.length;
      const centerLng = locations.reduce((sum, loc) => sum + loc.lng, 0) / locations.length;

      const map = L.map(mapDiv).setView([centerLat, centerLng], 6);

      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);
      
      const markers = L.featureGroup();

      locations.forEach((loc) => {
        const marker = L.marker([loc.lat, loc.lng]);
        marker.bindPopup(`<strong>${loc.nome}</strong>`);
        markers.addLayer(marker);
      });
      
      markers.addTo(map);

      // Ajusta o zoom para mostrar todos os marcadores
      if (markers.getBounds().isValid()) {
        map.fitBounds(markers.getBounds().pad(0.5)); // 0.5 de padding
      }
    }
  }

  // --- 3. LÓGICA DO BOTÃO "VOLTAR AO TOPO" ---
  function handleBackToTop() {
    if (backToTopButton) {
      if (window.scrollY > 300) {
        backToTopButton.classList.add("show");
      } else {
        backToTopButton.classList.remove("show");
      }
    }
  }

  if (backToTopButton) {
    backToTopButton.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  }

  // --- 4. LÓGICA DO MENU HAMBÚRGUER ---
  if (burgerMenu && mainNav) {
    burgerMenu.addEventListener("click", () => {
      mainNav.classList.toggle("show-mobile"); // Usar uma classe específica
      burgerMenu.classList.toggle("is-open");
      
      const icon = burgerMenu.querySelector("i");
      if (icon.classList.contains("ri-menu-line")) {
        icon.classList.remove("ri-menu-line");
        icon.classList.add("ri-close-line");
      } else {
        icon.classList.remove("ri-close-line");
        icon.classList.add("ri-menu-line");
      }
    });
  }
  // Adicione ao global.css:
  // @media (max-width: 768px) {
  //   .nav { display: none; }
  //   .nav.show-mobile { 
  //     display: flex; 
  //     flex-direction: column; 
  //     position: absolute; 
  //     top: 100%; 
  //     left: 0; 
  //     right: 0; 
  //     background: #0b598b; 
  //     padding: 20px 8%; 
  //   }
  // }
  

  // --- 5. LÓGICA DO FORMULÁRIO NEWSLETTER ---
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const email = newsletterEmail.value;
      if (email && newsletterMessage) {
        newsletterMessage.textContent = "Obrigado por se inscrever!";
        newsletterMessage.style.color = "#28a745"; // Verde sucesso
        newsletterEmail.value = "";
        
        setTimeout(() => {
            newsletterMessage.textContent = "";
        }, 3000);
      }
    });
  }

  // --- 6. VALIDAÇÃO SIMPLES DO FORM DE RESERVA ---
  if (bookingForm) {
    bookingForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const dataViagem = document.getElementById("data-viagem").value;
        
        if (!dataViagem) {
            bookingMessage.textContent = "Por favor, selecione uma data.";
            bookingMessage.style.color = "#f07913"; // Cor primária
        } else {
            bookingMessage.textContent = "Enviando sua reserva...";
            bookingMessage.style.color = "#28a745";
            // Aqui você enviaria o formulário de verdade
            // bookingForm.submit(); 
            console.log("Formulário pronto para envio!");
        }
    });
  }

  // --- INICIALIZAÇÃO ---
  window.addEventListener("scroll", handleBackToTop);
  initGallery();
  initSingleTripMap();
});