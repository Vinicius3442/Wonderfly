document.addEventListener('DOMContentLoaded', () => {

    /* --- LÓGICA DAS ABAS (PRINCIPAL E SECUNDÁRIA) --- */

    function setupTabs(navSelector, paneSelector, activeClass) {
        const tabLinks = document.querySelectorAll(navSelector);
        const tabPanes = document.querySelectorAll(paneSelector);

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                const tabId = link.dataset.tab;

                // 1. Desativa todos os links e painéis
                tabLinks.forEach(item => item.classList.remove(activeClass));
                tabPanes.forEach(pane => pane.classList.remove(activeClass));

                // 2. Ativa o link clicado e o painel correspondente
                link.classList.add(activeClass);
                document.getElementById('tab-' + tabId).classList.add(activeClass);
            });
        });
    }

    // Configura as abas principais (Viagens vs Momentos)
    setupTabs('.profile-tabs-nav .tab-link', '.tab-pane', 'active');
    
    // Configura as sub-abas (Próximas, Feitas, Desejos)
    setupTabs('.secondary-tabs .tab-link-secondary', '.tab-pane-secondary', 'active');


    /* --- LÓGICA DO MAPA DE MOMENTOS (LEAFLET) --- */
    
    // Seletores do formulário e galeria
    const mapElement = document.getElementById('moments-map');
    const momentForm = document.getElementById('moment-form');
    const cancelBtn = document.getElementById('cancel-moment');
    const gallery = document.getElementById('moments-gallery');
    const coordsSpan = document.getElementById('moment-coords');
    const latInput = document.getElementById('moment-lat');
    const lngInput = document.getElementById('moment-lng');
    const textInput = document.getElementById('moment-text');
    const photoInput = document.getElementById('moment-photo');

    // Só executa o código do mapa se o elemento do mapa existir
    if (mapElement) {
        // 1. Inicializa o mapa
        const map = L.map('moments-map').setView([20, 0], 2); // Visão global
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // 2. Ação ao clicar no mapa
        map.on('click', (e) => {
            const lat = e.latlng.lat.toFixed(4);
            const lng = e.latlng.lng.toFixed(4);
            
            // Preenche o formulário
            coordsSpan.textContent = `Lat: ${lat}, Lng: ${lng}`;
            latInput.value = lat;
            lngInput.value = lng;
            
            // Mostra o formulário
            momentForm.classList.remove('hidden');
        });

        // 3. Ação ao cancelar o formulário
        cancelBtn.addEventListener('click', () => {
            momentForm.classList.add('hidden');
            momentForm.reset();
        });

        // 4. Ação ao ENVIAR o formulário
        momentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const text = textInput.value;
            const photoFile = photoInput.files[0];
            const lat = latInput.value;
            const lng = lngInput.value;

            if (!text || !photoFile) {
                alert('Por favor, preencha a descrição e escolha uma foto.');
                return;
            }

            // Simulação de upload: usamos o FileReader para ler a foto
            // e mostrá-la na página (sem upload real para um servidor)
            const reader = new FileReader();
            reader.onload = function(event) {
                const photoUrl = event.target.result;

                // A. Adiciona o card na galeria
                const momentCard = `
                    <div class="moment-card">
                        <img src="${photoUrl}" alt="${text}">
                        <p>${text}</p>
                    </div>
                `;
                gallery.innerHTML += momentCard;

                // B. Adiciona o Pin (Marcador) no mapa
                const popupContent = `
                    <div class="moment-popup">
                        <img src="${photoUrl}" alt="${text}" style="width:100%; height:auto; border-radius: 5px;">
                        <p style="margin: 5px 0 0;">${text}</p>
                    </div>
                `;
                L.marker([lat, lng]).addTo(map)
                    .bindPopup(popupContent, { minWidth: 150 });

                // C. Reseta e esconde o formulário
                momentForm.reset();
                momentForm.classList.add('hidden');
            };
            
            reader.readAsDataURL(photoFile);
        });
    }

});