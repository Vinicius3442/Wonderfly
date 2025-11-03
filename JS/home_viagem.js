/* =============================================
   ARQUIVO: viagem_page.js (Versão Dinâmica)
   ============================================= */

// 'baseUrl' e 'tripLocations' são definidos no <script> do viagem.php

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

  // --- 1. LÓGICA DA GALERIA DE IMAGENS ---
  function initGallery() {
    if (!mainGalleryImage || thumbnailImages.length === 0) return;

    thumbnailImages.forEach((thumb) => {
      thumb.addEventListener("click", () => {
        const newSrc = thumb.src;
        const newAlt = thumb.alt;
        mainGalleryImage.src = newSrc;
        mainGalleryImage.alt = newAlt;

        mainGalleryImage.style.opacity = 0;
        setTimeout(() => {
          mainGalleryImage.style.opacity = 1;
        }, 100); 
      });
      thumb.style.cursor = "pointer";
    });
    
    mainGalleryImage.style.transition = "opacity 0.2s ease-in-out";
  }

  // --- 2. LÓGICA DO MAPA (DINÂMICO) ---
  function initSingleTripMap() {
    const mapDiv = document.getElementById("mapaDestinoUnico");
    
    // CORREÇÃO: Verifica se 'tripLocations' (do PHP) existe e não está vazia
    if (mapDiv && typeof tripLocations !== 'undefined' && tripLocations.length > 0) {
      
      const locations = tripLocations; // Usa a variável vinda do PHP

      // Encontra o centro (média)
      const centerLat = locations.reduce((sum, loc) => sum + parseFloat(loc.latitude), 0) / locations.length;
      const centerLng = locations.reduce((sum, loc) => sum + parseFloat(loc.longitude), 0) / locations.length;

      const map = L.map(mapDiv).setView([centerLat, centerLng], 6);

      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);
      
      const markers = L.featureGroup();

      locations.forEach((loc) => {
        // CORREÇÃO: Usa os nomes das colunas do banco ('latitude', 'longitude')
        const marker = L.marker([loc.latitude, loc.longitude]);
        marker.bindPopup(`<strong>${loc.nome}</strong>`);
        markers.addLayer(marker);
      });
      
      markers.addTo(map);

      // Ajusta o zoom para mostrar todos os marcadores
      if (markers.getBounds().isValid()) {
        map.fitBounds(markers.getBounds().pad(0.5)); // 0.5 de padding
      }
    } else if (mapDiv) {
      // Se não houver locais, esconde a seção do mapa
      const locationSection = mapDiv.closest('.location');
      if(locationSection) locationSection.style.display = 'none';
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
      // CORREÇÃO: Verifica 'fa-bars' ou 'ri-menu-line'
      if (icon.classList.contains("fa-bars") || icon.classList.contains("ri-menu-line")) {
        icon.classList.remove("fa-bars");
        icon.classList.remove("ri-menu-line");
        icon.classList.add("ri-close-line"); // Usa Remixicon para fechar
      } else {
        icon.classList.remove("ri-close-line");
        icon.classList.add("ri-menu-line"); // Usa Remixicon para abrir
      }
    });
  }
  
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

  // --- INICIALIZAÇÃO ---
  window.addEventListener("scroll", handleBackToTop);
  initGallery();
  initSingleTripMap(); // Agora é dinâmico!
});