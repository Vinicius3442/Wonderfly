/* =============================================
   ARQUIVO: perfil.js (CORRIGIDO)
   Lógica com Fetch para a página de perfil.
   ============================================= */

// (Variáveis 'userMoments' e 'baseUrl' são injetadas pelo perfil.php no final do HTML)

document.addEventListener('DOMContentLoaded', () => {

    // ===============================================
    // MUDANÇA 1: Declarar o 'map' aqui fora (com null)
    // ===============================================
    let map = null;

    /* =============================================
       1. LÓGICA DAS ABAS (COM A CORREÇÃO)
       ============================================= */
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

                // ===============================================
                // MUDANÇA 2: A CORREÇÃO DO MAPA
                // Se a aba clicada for a de momentos E o mapa existir...
                // ===============================================
                if (tabId === 'momentos' && map) {
                    // Espera 1 milissegundo para o 'display: block' da aba
                    // ser renderizado e SÓ ENTÃO recalcula o tamanho.
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 1);
                }
            });
        });
    }
    setupTabs('.profile-tabs-nav .tab-link', '.tab-pane', 'active');
    setupTabs('.secondary-tabs .tab-link-secondary', '.tab-pane-secondary', 'active');
    

    /* =============================================
       2. LÓGICA DE EDIÇÃO DO PERFIL (Refatorada)
       ============================================= */
    const editBtn = document.getElementById('edit-profile-btn');
    const modal = document.getElementById('profile-edit-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    const editForm = document.getElementById('profile-edit-form');

    // Seletores dos elementos da página
    const avatarImg = document.getElementById('profile-avatar');
    const bannerEl = document.querySelector('.profile-banner');
    const nameEl = document.getElementById('profile-name');
    const bioEl = document.getElementById('profile-bio');

    function openModal() { modal.classList.add('show'); }
    function closeModal() { modal.classList.remove('show'); }

    editBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // --- NOVA LÓGICA DE SALVAR COM FETCH ---
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitButton = editForm.querySelector('button[type="submit"]');
        submitButton.textContent = 'Salvando...';
        submitButton.disabled = true;

        // 1. Cria o FormData (essencial para enviar arquivos)
        const formData = new FormData(editForm);

        try {
            // 2. Envia para a API
            const response = await fetch(`${baseUrl}api/update_perfil.php`, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Falha na resposta da rede');

            const result = await response.json();

            if (result.success) {
                // 3. Atualiza a página com os novos dados
                nameEl.textContent = result.nome;
                bioEl.textContent = result.bio || 'Clique em "Editar Perfil" para adicionar sua bio!';
                
                if (result.avatar_url) {
                    avatarImg.src = result.avatar_url + `?v=${Date.now()}`; // Força o cache-bust
                }
                if (result.banner_url) {
                    bannerEl.style.backgroundImage = `url(${result.banner_url}?v=${Date.now()})`;
                }
                
                closeModal();
                Swal.fire('Sucesso!', 'Seu perfil foi atualizado.', 'success');
            } else {
                throw new Error(result.message || 'Erro ao salvar');
            }

        } catch (error) {
            Swal.fire('Erro!', error.message, 'error');
        } finally {
            submitButton.textContent = 'Salvar Alterações';
            submitButton.disabled = false;
        }
    });


    /* =============================================
       3. LÓGICA DO MAPA DE MOMENTOS (Refatorada)
       ============================================= */
    
    const mapElement = document.getElementById('moments-map');
    if (mapElement) {
        const momentForm = document.getElementById('moment-form');
        const cancelBtn = document.getElementById('cancel-moment');
        const gallery = document.getElementById('moments-gallery');
        const coordsSpan = document.getElementById('moment-coords');
        const latInput = document.getElementById('moment-lat');
        const lngInput = document.getElementById('moment-lng');
        const galleryPlaceholder = document.getElementById('gallery-placeholder');

        let tempMarker = null;
        let allMarkers = {}; // Para guardar os marcadores permanentes

        // ===============================================
        // MUDANÇA 3: Mude de 'const map' para 'map ='
        // (para usarmos a variável que declaramos lá em cima)
        // ===============================================
        map = L.map('moments-map').setView([20, 0], 2); // ANTES: const map = ...
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // --- NOVO: Carrega marcadores existentes do PHP ---
        function loadExistingMarkers() {
            userMoments.forEach(momento => {
                addPermanentMarker(momento);
            });
        }
        
        function addPermanentMarker(momento) {
            const popupContent = `
                <div class="moment-popup">
                    <img src="${baseUrl}${momento.foto_url}" alt="${momento.descricao}">
                    <p>${momento.descricao}</p>
                </div>
            `;
            const marker = L.marker([momento.latitude, momento.longitude])
                .addTo(map)
                .bindPopup(popupContent, { minWidth: 150 });
            
            allMarkers[momento.id] = marker; // Salva referência
        }

        // --- Lógica de clicar no mapa (igual) ---
        map.on('click', (e) => {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            if (tempMarker) tempMarker.remove();
            
            tempMarker = L.marker([lat, lng], { draggable: true }).addTo(map);
            tempMarker.bindPopup("<b>Novo Momento</b><br>Arraste para ajustar.").openPopup();
            
            tempMarker.on('dragend', (e) => fetchAddress(e.target.getLatLng().lat, e.target.getLatLng().lng));
            
            fetchAddress(lat, lng);
            momentForm.classList.remove('hidden');
        });
        
        async function fetchAddress(lat, lng) {
            coordsSpan.textContent = 'Buscando endereço...';
            latInput.value = lat;
            lngInput.value = lng;
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=pt-BR`);
                const data = await response.json();
                const address = data.display_name ? data.display_name.substring(0, 60) + '...' : `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
                coordsSpan.textContent = address;
            } catch (error) {
                coordsSpan.textContent = `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
            }
        }
        
        function resetFormAndTempMarker() {
            momentForm.classList.add('hidden');
            momentForm.reset();
            if (tempMarker) {
                tempMarker.remove();
                tempMarker = null;
            }
        }
        
        function checkGalleryEmpty() {
            const cardCount = gallery.querySelectorAll('.moment-card').length;
            galleryPlaceholder.style.display = cardCount === 0 ? 'flex' : 'none';
        }

        // --- NOVA LÓGICA DE SALVAR MOMENTO COM FETCH ---
        momentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = momentForm.querySelector('button[type="submit"]');
            submitButton.textContent = 'Salvando...';
            submitButton.disabled = true;

            const formData = new FormData(momentForm);

            try {
                const response = await fetch(`${baseUrl}api/add_momento.php`, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Falha na resposta da rede');
                const result = await response.json();

                if (result.success) {
                    // Adiciona o novo momento na galeria e no mapa
                    renderNewMomentCard(result.momento);
                    addPermanentMarker(result.momento);
                    resetFormAndTempMarker();
                    checkGalleryEmpty();
                    Swal.fire('Sucesso!', 'Seu momento foi salvo.', 'success');
                } else {
                    throw new Error(result.message || 'Erro ao salvar momento.');
                }
            } catch (error) {
                Swal.fire('Erro!', error.message, 'error');
            } finally {
                submitButton.textContent = 'Salvar Momento';
                submitButton.disabled = false;
            }
        });
        
        cancelBtn.addEventListener('click', resetFormAndTempMarker);

        // Função helper para adicionar novo card na galeria
        function renderNewMomentCard(momento) {
            const date = new Date(momento.data_criacao).toLocaleDateString('pt-BR');
            const cardElement = document.createElement('div');
            cardElement.className = 'moment-card';
            cardElement.dataset.id = momento.id;
            cardElement.innerHTML = `
                <img src="${momento.foto_url}" alt="${momento.descricao}">
                <div class="moment-card-content">
                    <p>${momento.descricao}</p>
                    <small>Adicionado em: ${date}</small>
                    <div class="moment-card-actions">
                        <button class="btn-view-map" data-lat="${momento.latitude}" data-lng="${momento.longitude}"><i class="ri-map-pin-line"></i> Ver no Mapa</button>
                        <button class="btn-delete"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
            `;
            gallery.prepend(cardElement); // Adiciona no início
        }
        
        // --- NOVA LÓGICA DE DELETAR MOMENTO COM FETCH ---
        gallery.addEventListener('click', (e) => {
            const viewBtn = e.target.closest('.btn-view-map');
            const deleteBtn = e.target.closest('.btn-delete');
            const card = e.target.closest('.moment-card');
            
            if (!card) return;
            const momentId = card.dataset.id;
            
            if (viewBtn) {
                const lat = viewBtn.dataset.lat;
                const lng = viewBtn.dataset.lng;
                map.flyTo([lat, lng], 15);
                if(allMarkers[momentId]) {
                    allMarkers[momentId].openPopup();
                }
            }

            if (deleteBtn) {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f07913',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteMoment(momentId, card);
                    }
                });
            }
        });

        async function deleteMoment(momentId, cardElement) {
            try {
                const response = await fetch(`${baseUrl}api/delete_momento.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: momentId })
                });

                if (!response.ok) throw new Error('Falha na resposta da rede');
                const result = await response.json();

                if (result.success) {
                    cardElement.remove(); // Remove da galeria
                    if (allMarkers[momentId]) {
                        allMarkers[momentId].remove(); // Remove do mapa
                        delete allMarkers[momentId];
                    }
                    checkGalleryEmpty();
                    Swal.fire('Excluído!', 'Seu momento foi removido.', 'success');
                } else {
                    throw new Error(result.message || 'Erro ao excluir');
                }
            } catch (error) {
                Swal.fire('Erro!', error.message, 'error');
            }
        }
        
        // --- INICIALIZAÇÃO ---
        loadExistingMarkers(); // Adiciona os marcadores do PHP
        checkGalleryEmpty(); // Checa a galeria
    }

}); // Fim do DOMContentLoaded