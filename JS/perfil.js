/* =============================================
   ARQUIVO: perfil.js (CORRIGIDO E COMPLETO)
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    // ===============================================
    // 1. VARIÁVEIS GLOBAIS
    // ===============================================
    let map = null;
    let tempMarker = null;

    // ===============================================
    // 2. LÓGICA DAS ABAS
    // ===============================================
    function setupTabs(navSelector, paneSelector, activeClass) {
        const tabLinks = document.querySelectorAll(navSelector);
        const tabPanes = document.querySelectorAll(paneSelector);

        tabLinks.forEach(link => {
            link.addEventListener('click', () => {
                const tabId = link.dataset.tab;

                // Remove active de todos
                tabLinks.forEach(item => item.classList.remove(activeClass));
                tabPanes.forEach(pane => pane.classList.remove(activeClass));

                // Adiciona active no clicado
                link.classList.add(activeClass);
                const targetPane = document.getElementById('tab-' + tabId);
                if (targetPane) {
                    targetPane.classList.add(activeClass);
                }

                // CORREÇÃO DO MAPA: Se a aba for 'momentos', redimensiona o mapa
                if (tabId === 'momentos' && map) {
                    setTimeout(() => {
                        map.invalidateSize();
                    }, 100);
                }
            });
        });
    }
    setupTabs('.profile-tabs-nav .tab-link', '.tab-pane', 'active');
    setupTabs('.secondary-tabs .tab-link-secondary', '.tab-pane-secondary', 'active');


    // ===============================================
    // 3. EDIÇÃO DO PERFIL
    // ===============================================
    const editBtn = document.getElementById('edit-profile-btn');
    const modal = document.getElementById('profile-edit-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    const editForm = document.getElementById('profile-edit-form');

    // Elementos da UI para atualizar após salvar
    const avatarImg = document.getElementById('profile-avatar');
    const bannerEl = document.querySelector('.profile-banner');
    const nameEl = document.getElementById('profile-name');
    const bioEl = document.getElementById('profile-bio');

    if (editBtn && modal) {
        function openModal() { modal.classList.add('show'); }
        function closeModal() { modal.classList.remove('show'); }

        editBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = editForm.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
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
                    // Atualiza UI
                    if (nameEl) nameEl.textContent = result.nome;
                    if (bioEl) bioEl.textContent = result.bio || 'Clique em "Editar Perfil" para adicionar sua bio!';
                    if (result.avatar_url && avatarImg) {
                        avatarImg.src = result.avatar_url + `?v=${Date.now()}`;
                    }
                    if (result.banner_url && bannerEl) {
                        bannerEl.style.backgroundImage = `url(${result.banner_url}?v=${Date.now()})`;
                    }

                    closeModal();

                    let message = 'Seu perfil foi atualizado.';
                    let icon = 'success';

                    if (result.warnings && result.warnings.length > 0) {
                        message += '<br><br><strong>Atenção:</strong><br>' + result.warnings.join('<br>');
                        icon = 'warning';
                    }

                    Swal.fire('Sucesso!', message, icon);
                } else {
                    throw new Error(result.message || 'Erro ao salvar');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Erro!', error.message, 'error');
            } finally {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }


    // ===============================================
    // 4. MAPA DE MOMENTOS
    // ===============================================
    const mapElement = document.getElementById('moments-map');

    if (mapElement) {
        const momentForm = document.getElementById('moment-form');
        const cancelBtn = document.getElementById('cancel-moment');
        const coordsSpan = document.getElementById('moment-coords');
        const latInput = document.getElementById('moment-lat');
        const lngInput = document.getElementById('moment-lng');
        const galleryPlaceholder = document.getElementById('gallery-placeholder');

        let tempMarker = null;
        let allMarkers = {};

        // Inicializa o mapa
        map = L.map('moments-map').setView([20, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const momentoIcon = L.icon({
            iconUrl: `${baseUrl}images/logo.png`,
            iconSize: [32, 37],
            iconAnchor: [16, 37],
            popupAnchor: [0, -38]
        });

        // Carrega marcadores existentes (userMoments vem do PHP)
        if (typeof userMoments !== 'undefined' && Array.isArray(userMoments)) {
            userMoments.forEach(momento => {
                addPermanentMarker(momento);
            });
        }

        // Clique no mapa para adicionar novo
        map.on('click', (e) => {
            const { lat, lng } = e.latlng;

            // Remove marcador temporário anterior se houver
            if (tempMarker) {
                map.removeLayer(tempMarker);
            }

            // Cria novo marcador temporário
            tempMarker = L.marker([lat, lng], { icon: momentoIcon }).addTo(map);

            // Preenche o formulário
            latInput.value = lat;
            lngInput.value = lng;
            coordsSpan.textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;

            // Mostra o formulário
            momentForm.classList.remove('hidden');
            momentForm.scrollIntoView({ behavior: 'smooth' });
        });

        // Cancelar adição
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                momentForm.classList.add('hidden');
                if (tempMarker) {
                    map.removeLayer(tempMarker);
                    tempMarker = null;
                }
                momentForm.reset();
            });
        }

        // Salvar Momento
        if (momentForm) {
            momentForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(momentForm);

                try {
                    const response = await fetch(`${baseUrl}api/add_momento.php`, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Adiciona marcador permanente
                        addPermanentMarker(result.momento);

                        // Adiciona à galeria (opcional, recarregar a página é mais fácil para atualizar tudo)
                        // Mas vamos recarregar para garantir sincronia
                        window.location.reload();

                    } else {
                        Swal.fire('Erro', result.message || 'Erro ao salvar momento', 'error');
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire('Erro', 'Erro de conexão', 'error');
                }
            });
        }

        // Função helper para adicionar marcador
        function addPermanentMarker(momento) {
            const popupContent = `
                <div style="text-align:center">
                    <img src="${baseUrl}${momento.foto_url}" style="width:100px;height:100px;object-fit:cover;border-radius:4px;margin-bottom:5px">
                    <p><strong>${momento.descricao}</strong></p>
                    <small>${new Date(momento.data_criacao).toLocaleDateString()}</small>
                </div>
            `;
            const marker = L.marker([momento.latitude, momento.longitude], { icon: momentoIcon })
                .addTo(map)
                .bindPopup(popupContent);

            // Armazena referência para poder excluir depois
            if (momento.id) {
                allMarkers[momento.id] = marker;
            }
        }

        // Botões "Ver no Mapa" da galeria
        document.querySelectorAll('.btn-view-map').forEach(btn => {
            btn.addEventListener('click', () => {
                const card = btn.closest('.moment-card');
                // Pega lat/lng do botão ou do card se precisar, mas aqui o botão já tem dataset
                const lat = parseFloat(btn.dataset.lat);
                const lng = parseFloat(btn.dataset.lng);
                const id = card.dataset.id;

                // Muda para a aba mapa se não estiver nela
                // Se quiser abrir o popup também:
                if (allMarkers[id]) {
                    allMarkers[id].openPopup();
                }

                map.setView([lat, lng], 10);
                window.scrollTo({ top: mapElement.offsetTop - 100, behavior: 'smooth' });
            });
        });

        // Botões de Excluir
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                const card = e.target.closest('.moment-card');
                const id = card.dataset.id;

                const confirm = await Swal.fire({
                    title: 'Tem certeza?',
                    text: "Não será possível reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, excluir!'
                });

                if (confirm.isConfirmed) {
                    try {
                        const response = await fetch(`${baseUrl}api/delete_momento.php`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: id })
                        });
                        const result = await response.json();

                        if (result.success) {
                            // Remove do HTML
                            card.remove();

                            // Remove do MAPA
                            if (allMarkers[id]) {
                                map.removeLayer(allMarkers[id]);
                                delete allMarkers[id];
                            }

                            Swal.fire('Deletado!', 'Seu momento foi excluído.', 'success');

                            // Se não sobrar nenhum, mostra placeholder (opcional)
                            if (document.querySelectorAll('.moment-card').length === 0) {
                                if (galleryPlaceholder) galleryPlaceholder.style.display = 'flex';
                            }
                        } else {
                            Swal.fire('Erro', result.message, 'error');
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire('Erro', 'Erro de conexão', 'error');
                    }
                }
            });
        });
    }

});