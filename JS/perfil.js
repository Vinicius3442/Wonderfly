/* =============================================
   ARQUIVO: perfil_novo.js (COM A CORREÇÃO DO MAPA)
   ============================================= */

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
                // ===============================================
                if (tabId === 'momentos' && map) {
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

    if (editBtn) { // Adiciona verificação se o botão existe
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

            const formData = new FormData(editForm);

            try {
                const response = await fetch(`${baseUrl}api/update_perfil.php`, {
                    method: 'POST',
                    body: formData
                });
                if (!response.ok) throw new Error('Falha na resposta da rede');
                const result = await response.json();
                if (result.success) {
                    nameEl.textContent = result.nome;
                    bioEl.textContent = result.bio || 'Clique em "Editar Perfil" para adicionar sua bio!';
                    if (result.avatar_url) {
                        avatarImg.src = result.avatar_url + `?v=${Date.now()}`;
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
    } // Fim do if(editBtn)


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
        let allMarkers = {}; 

        // ===============================================
        // MUDANÇA 3: Mude de 'const map' para 'map ='
        // ===============================================
        map = L.map('moments-map').setView([20, 0], 2);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // --- Carrega marcadores existentes do PHP ---
        function loadExistingMarkers() {
            // 'userMoments' é injetado pelo perfil.php
            if (typeof userMoments !== 'undefined') {
                userMoments.forEach(momento => {
                    addPermanentMarker(momento);
                });
            }
        }
        
        function addPermanentMarker(momento) {
            const popupContent