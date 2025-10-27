/* =============================================
   ARQUIVO: perfil.js
   Lógica para a página de perfil (Abas, Mapa e Edição de Banner).
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* --- LÓGICA DAS ABAS (PRINCIPAL E SECUNDÁRIA) --- */
    function setupTabs(navSelector, paneSelector, activeClass) {
        const tabLinks = document.querySelectorAll(navSelector);
        const tabPanes = document.querySelectorAll(paneSelector);

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                const tabId = link.dataset.tab;
                tabLinks.forEach(item => item.classList.remove(activeClass));
                tabPanes.forEach(pane => pane.classList.remove(activeClass));
                link.classList.add(activeClass);
                document.getElementById('tab-' + tabId).classList.add(activeClass);
            });
        });
    }
    setupTabs('.profile-tabs-nav .tab-link', '.tab-pane', 'active');
    setupTabs('.secondary-tabs .tab-link-secondary', '.tab-pane-secondary', 'active');
    

    /* =============================================
       LÓGICA DO MAPA DE MOMENTOS
       (Esta seção inteira não mudou)
       ============================================= */
    
    const mapElement = document.getElementById('moments-map');
    if (mapElement) {
        const momentForm = document.getElementById('moment-form');
        const cancelBtn = document.getElementById('cancel-moment');
        const gallery = document.getElementById('moments-gallery');
        const coordsSpan = document.getElementById('moment-coords');
        const latInput = document.getElementById('moment-lat');
        const lngInput = document.getElementById('moment-lng');
        const textInput = document.getElementById('moment-text');
        const photoInput = document.getElementById('moment-photo');
        const galleryPlaceholder = document.getElementById('gallery-placeholder'); // Placeholder

        let allMoments = []; 
        let tempMarker = null; 

        const map = L.map('moments-map').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.on('click', (e) => {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            if (tempMarker) {
                tempMarker.remove();
            }

            tempMarker = L.marker([lat, lng], {
                draggable: true, 
                autoPan: true
            }).addTo(map);

            tempMarker.bindPopup("<b>Novo Momento</b><br>Arraste para ajustar a localização.").openPopup();

            tempMarker.on('dragend', (e) => {
                const newLat = e.target.getLatLng().lat;
                const newLng = e.target.getLatLng().lng;
                fetchAddress(newLat, newLng); 
            });

            fetchAddress(lat, lng); 
            momentForm.classList.remove('hidden');
        });
        
        function updateFormCoords(lat, lng, address) {
            const displayText = address || `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
            coordsSpan.textContent = displayText;
            latInput.value = lat;
            lngInput.value = lng;
        }

        async function fetchAddress(lat, lng) {
            coordsSpan.textContent = 'Buscando endereço...';
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=pt-BR`);
                if (!response.ok) {
                    throw new Error('API de geocodificação falhou');
                }
                const data = await response.json();
                if (data && data.display_name) {
                    const shortAddress = data.display_name.length > 60 ? data.display_name.substring(0, 60) + '...' : data.display_name;
                    updateFormCoords(lat, lng, shortAddress);
                } else {
                    updateFormCoords(lat, lng, "Local desconhecido");
                }
            } catch (error) {
                console.error('Erro ao buscar endereço:', error);
                updateFormCoords(lat, lng, null); 
            }
        }
        
        cancelBtn.addEventListener('click', () => {
            resetFormAndTempMarker();
        });

        function resetFormAndTempMarker() {
            momentForm.classList.add('hidden');
            momentForm.reset();
            if (tempMarker) {
                tempMarker.remove();
                tempMarker = null;
            }
        }
        
        // Função para checar se a galeria está vazia
        function checkGalleryEmpty() {
            if (allMoments.length === 0) {
                galleryPlaceholder.style.display = 'flex';
            } else {
                galleryPlaceholder.style.display = 'none';
            }
        }

        momentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const text = textInput.value;
            const photoFile = photoInput.files[0];
            const lat = latInput.value;
            const lng = lngInput.value;
            const date = new Date().toLocaleDateString('pt-BR');
            const momentId = 'moment-' + Date.now(); 

            if (!text.trim() || !photoFile) {
                Swal.fire('Ops!', 'Por favor, preencha a descrição e escolha uma foto.', 'warning');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const photoUrl = event.target.result;

                const popupContent = `
                    <div class="moment-popup">
                        <img src="${photoUrl}" alt="${text}" style="width:100%; height:auto; border-radius: 5px;">
                        <p style="margin: 5px 0 0;">${text}</p>
                    </div>
                `;
                const permanentMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(popupContent, { minWidth: 150 });

                const cardElement = document.createElement('div');
                cardElement.className = 'moment-card';
                cardElement.dataset.id = momentId; 
                cardElement.innerHTML = `
                    <img src="${photoUrl}" alt="${text}">
                    <div class="moment-card-content">
                        <p>${text}</p>
                        <small>Adicionado em: ${date}</small>
                        <div class="moment-card-actions">
                            <button class="btn-view-map" data-lat="${lat}" data-lng="${lng}"><i class="ri-map-pin-line"></i> Ver no Mapa</button>
                            <button class="btn-delete"><i class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>
                `;
                gallery.prepend(cardElement); 

                allMoments.push({
                    id: momentId,
                    marker: permanentMarker,
                    card: cardElement,
                    lat: lat,
                    lng: lng
                });

                resetFormAndTempMarker();
                checkGalleryEmpty(); // Verifica a galeria
            };
            
            reader.readAsDataURL(photoFile);
        });

        gallery.addEventListener('click', (e) => {
            const viewBtn = e.target.closest('.btn-view-map');
            const deleteBtn = e.target.closest('.btn-delete');
            const card = e.target.closest('.moment-card');
            
            if (!card) return; 
            
            const momentId = card.dataset.id;
            const moment = allMoments.find(m => m.id === momentId);
            if (!moment) return;

            if (viewBtn) {
                map.flyTo([moment.lat, moment.lng], 15); 
                moment.marker.openPopup();
            }

            if (deleteBtn) {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f07913', 
                    cancelButtonColor: '#6c757d',  
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        moment.marker.remove();
                        moment.card.remove();
                        allMoments = allMoments.filter(m => m.id !== momentId);
                        
                        checkGalleryEmpty(); // Verifica a galeria

                        Swal.fire(
                            'Excluído!',
                            'Seu momento foi removido.',
                            'success'
                        );
                    }
                });
            }
        });
        
        checkGalleryEmpty(); // Verifica ao carregar a página
        
    } // fim do if(mapElement)


    /* =============================================
       LÓGICA DE EDIÇÃO DO PERFIL (ATUALIZADA)
       ============================================= */

    // --- Seletores dos Elementos do Perfil ---
    const avatarImg = document.getElementById('profile-avatar');
    const bannerEl = document.querySelector('.profile-banner'); // NOVO
    const nameEl = document.getElementById('profile-name');
    const bioEl = document.getElementById('profile-bio');
    
    // --- Seletores do Modal e Formulário ---
    const editBtn = document.getElementById('edit-profile-btn');
    const modal = document.getElementById('profile-edit-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    const editForm = document.getElementById('profile-edit-form');

    // --- Seletores dos Inputs do Formulário ---
    const editNameInput = document.getElementById('edit-name');
    const editBioInput = document.getElementById('edit-bio');
    const editAvatarInput = document.getElementById('edit-avatar');
    const editBannerInput = document.getElementById('edit-banner'); // NOVO

    // 1. FUNÇÃO: Carregar dados do localStorage
    function loadProfileData() {
        const savedName = localStorage.getItem('profileName');
        const savedBio = localStorage.getItem('profileBio');
        const savedAvatar = localStorage.getItem('profileAvatar');
        const savedBanner = localStorage.getItem('profileBanner'); // NOVO

        if (savedName) {
            nameEl.textContent = savedName;
            editNameInput.value = savedName; 
        }
        if (savedBio) {
            bioEl.textContent = savedBio;
            editBioInput.value = savedBio; 
        }
        if (savedAvatar) {
            avatarImg.src = savedAvatar;
        }
        if (savedBanner) { // NOVO
            // Aplicamos como imagem de fundo
            bannerEl.style.backgroundImage = `url(${savedBanner})`;
        }
    }

    // 2. FUNÇÃO: Abrir e Fechar o Modal
    function openModal() {
        modal.classList.add('show');
    }
    function closeModal() {
        modal.classList.remove('show');
    }

    // 3. FUNÇÃO HELPER: Ler arquivo como Base64 (Retorna uma Promise)
    // Isso nos permite ler múltiplos arquivos de forma limpa
    function readFileAsBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (event) => resolve(event.target.result); // Resolve com a string Base64
            reader.onerror = (error) => reject(error);
            reader.readAsDataURL(file);
        });
    }

    // 4. FUNÇÃO: Salvar Dados (Refatorada com async/await)
    editForm.addEventListener('submit', async (e) => { // A função agora é 'async'
        e.preventDefault();

        // --- Salva Nome e Bio (são simples) ---
        const newName = editNameInput.value;
        const newBio = editBioInput.value;
        localStorage.setItem('profileName', newName);
        localStorage.setItem('profileBio', newBio);
        nameEl.textContent = newName;
        bioEl.textContent = newBio;

        // --- Salva Imagens (com Promises) ---
        const avatarFile = editAvatarInput.files[0];
        const bannerFile = editBannerInput.files[0];

        try {
            // Cria "promessas" de leitura para os arquivos, se eles existirem
            const avatarPromise = avatarFile ? readFileAsBase64(avatarFile) : Promise.resolve(null);
            const bannerPromise = bannerFile ? readFileAsBase64(bannerFile) : Promise.resolve(null);
            
            // Espera as duas leituras terminarem
            const [avatarBase64, bannerBase64] = await Promise.all([avatarPromise, bannerPromise]);

            // Se a leitura do avatar terminou, salva e atualiza
            if (avatarBase64) {
                localStorage.setItem('profileAvatar', avatarBase64);
                avatarImg.src = avatarBase64;
            }

            // Se a leitura do banner terminou, salva e atualiza
            if (bannerBase64) {
                localStorage.setItem('profileBanner', bannerBase64);
                bannerEl.style.backgroundImage = `url(${bannerBase64})`;
            }

            // Fecha o modal e mostra sucesso DEPOIS que tudo terminou
            closeModal();
            Swal.fire({
                title: 'Sucesso!',
                text: 'Seu perfil foi atualizado.',
                icon: 'success',
                confirmButtonColor: '#f07913'
            });

        } catch (error) {
            // Se der erro em UMA das leituras, avisa o usuário
            console.error("Erro ao ler arquivos:", error);
            Swal.fire({
                title: 'Erro!',
                text: 'Houve um problema ao carregar sua imagem.',
                icon: 'error',
                confirmButtonColor: '#f07913'
            });
        }
    });

    // 5. Conecta os Event Listeners (Gatilhos)
    editBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    
    // Fecha o modal se clicar fora dele
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // 6. EXECUÇÃO: Carrega os dados assim que a página abre
    loadProfileData();

});