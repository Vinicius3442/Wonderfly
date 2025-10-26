/* =============================================
   ARQUIVO: perfil.js
   Lógica para a página de perfil (Abas e Mapa APRIMORADOS).
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* --- LÓGICA DAS ABAS (PRINCIPAL E SECUNDÁRIA) --- */
    // (Esta parte permanece a mesma)
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
                // CORREÇÃO: Adicionamos 'tab-' na frente do tabId
                document.getElementById('tab-' + tabId).classList.add(activeClass);
            });
        });
    }
    setupTabs('.profile-tabs-nav .tab-link', '.tab-pane', 'active');
    setupTabs('.secondary-tabs .tab-link-secondary', '.tab-pane-secondary', 'active');
    

    /* =============================================
       LÓGICA DO MAPA DE MOMENTOS (APRIMORADA)
       ============================================= */
    
    const mapElement = document.getElementById('moments-map');
    if (mapElement) {
        // --- Seletores ---
        const momentForm = document.getElementById('moment-form');
        const cancelBtn = document.getElementById('cancel-moment');
        const gallery = document.getElementById('moments-gallery');
        const coordsSpan = document.getElementById('moment-coords');
        const latInput = document.getElementById('moment-lat');
        const lngInput = document.getElementById('moment-lng');
        const textInput = document.getElementById('moment-text');
        const photoInput = document.getElementById('moment-photo');

        // --- Variáveis de Estado ---
        let allMoments = []; // "Banco de dados" dos momentos
        let tempMarker = null; // Marcador temporário

        // 1. Inicializa o mapa
        const map = L.map('moments-map').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // 2. Ação ao clicar no mapa (APRIMORADO)
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

            // Atualiza o formulário quando o pin é arrastado
            tempMarker.on('dragend', (e) => {
                const newLat = e.target.getLatLng().lat;
                const newLng = e.target.getLatLng().lng;
                
                // Chama a nova função de busca de endereço
                fetchAddress(newLat, newLng); 
            });

            // Chama a nova função de busca de endereço
            fetchAddress(lat, lng); 
            momentForm.classList.remove('hidden');
        });
        
        // 3. Função helper para atualizar o formulário (MODIFICADA)
        // Agora ela aceita um 'address'
        function updateFormCoords(lat, lng, address) {
            // Se o endereço existir, mostre-o. Senão, volte para as coordenadas.
            const displayText = address || `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
            
            coordsSpan.textContent = displayText;
            latInput.value = lat;
            lngInput.value = lng;
        }

        // 4. NOVA FUNÇÃO: Buscar o endereço (Reverse Geocoding)
        async function fetchAddress(lat, lng) {
            // Mostra um feedback imediato de carregamento
            coordsSpan.textContent = 'Buscando endereço...';

            try {
                // A 'async/await' torna o código mais limpo
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=pt-BR`);
                
                if (!response.ok) {
                    throw new Error('API de geocodificação falhou');
                }
                
                const data = await response.json();
                
                // O 'display_name' é o endereço completo (ex: "Rua, Bairro, Cidade, País")
                if (data && data.display_name) {
                    // Trunca o endereço se for muito longo
                    const shortAddress = data.display_name.length > 60 ? data.display_name.substring(0, 60) + '...' : data.display_name;
                    updateFormCoords(lat, lng, shortAddress);
                } else {
                    // Se a API não achar (ex: no meio do oceano)
                    updateFormCoords(lat, lng, "Local desconhecido");
                }

            } catch (error) {
                console.error('Erro ao buscar endereço:', error);
                // Se a API falhar, mostra as coordenadas como fallback
                updateFormCoords(lat, lng, null); 
            }
        }
        // 3. Ação ao CANCELAR o formulário
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

        // 4. Ação ao ENVIAR o formulário (APRIMORADO)
        momentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const text = textInput.value;
            const photoFile = photoInput.files[0];
            const lat = latInput.value;
            const lng = lngInput.value;
            const date = new Date().toLocaleDateString('pt-BR');
            const momentId = 'moment-' + Date.now(); // ID único

            if (!text || !photoFile) {
                alert('Por favor, preencha a descrição e escolha uma foto.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                const photoUrl = event.target.result;

                // A. Adiciona o Marcador PERMANENTE no mapa
                const popupContent = `
                    <div class="moment-popup">
                        <img src="${photoUrl}" alt="${text}" style="width:100%; height:auto; border-radius: 5px;">
                        <p style="margin: 5px 0 0;">${text}</p>
                    </div>
                `;
                const permanentMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(popupContent, { minWidth: 150 });

                // B. Adiciona o Card na Galeria (APRIMORADO)
                const cardElement = document.createElement('div');
                cardElement.className = 'moment-card';
                cardElement.dataset.id = momentId; // Guarda o ID no elemento
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
                gallery.prepend(cardElement); // Adiciona no início da lista

                // C. Salva no nosso "banco de dados"
                allMoments.push({
                    id: momentId,
                    marker: permanentMarker,
                    card: cardElement,
                    lat: lat,
                    lng: lng
                });

                // D. Limpa o formulário e o pin temporário
                resetFormAndTempMarker();
            };
            
            reader.readAsDataURL(photoFile);
        });

        // 5. APRIMORAMENTO 2 & 3: Ações da Galeria (Ver no Mapa / Excluir)
        // Usamos "event delegation" para escutar cliques nos botões
        gallery.addEventListener('click', (e) => {
            // Encontra o botão ou o card que foi clicado
            const viewBtn = e.target.closest('.btn-view-map');
            const deleteBtn = e.target.closest('.btn-delete');
            const card = e.target.closest('.moment-card');
            
            if (!card) return; // Sai se o clique não foi em um card
            
            const momentId = card.dataset.id;
            const moment = allMoments.find(m => m.id === momentId);
            if (!moment) return;

            // Ação: VER NO MAPA
            if (viewBtn) {
                map.flyTo([moment.lat, moment.lng], 15); // Zoom 15 (cidade)
                moment.marker.openPopup();
            }

            // Ação: EXCLUIR
            if (deleteBtn) {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f07913', // Cor laranja do seu tema
                    cancelButtonColor: '#6c757d',  // Cinza
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    // Isso é executado DEPOIS que o usuário clica
                    if (result.isConfirmed) {
                        // --- O usuário clicou em "Sim, excluir!" ---
                        
                        // Remove do mapa
                        moment.marker.remove();
                        // Remove da galeria
                        moment.card.remove();
                        // Remove do "banco de dados"
                        allMoments = allMoments.filter(m => m.id !== momentId);

                        // Opcional: Mostrar um alerta de sucesso
                        Swal.fire(
                            'Excluído!',
                            'Seu momento foi removido.',
                            'success'
                        );
                    }
                });
            }
            
        });
        
    } // fim do if(mapElement)
    const avatarImg = document.getElementById('profile-avatar');
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

    // 1. FUNÇÃO: Carregar dados do localStorage
    function loadProfileData() {
        const savedName = localStorage.getItem('profileName');
        const savedBio = localStorage.getItem('profileBio');
        const savedAvatar = localStorage.getItem('profileAvatar'); // (Salvo como texto Base64)

        if (savedName) {
            nameEl.textContent = savedName;
            editNameInput.value = savedName; // Pré-preenche o formulário
        }
        if (savedBio) {
            bioEl.textContent = savedBio;
            editBioInput.value = savedBio; // Pré-preenche o formulário
        }
        if (savedAvatar) {
            avatarImg.src = savedAvatar;
        }
    }

    // 2. FUNÇÃO: Abrir e Fechar o Modal
    function openModal() {
        modal.classList.add('show');
    }
    function closeModal() {
        modal.classList.remove('show');
    }

    // 3. FUNÇÃO: Salvar Dados
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Salva Nome e Bio (são simples)
        const newName = editNameInput.value;
        const newBio = editBioInput.value;

        localStorage.setItem('profileName', newName);
        localStorage.setItem('profileBio', newBio);

        nameEl.textContent = newName;
        bioEl.textContent = newBio;

        // Salva a Foto (requer FileReader)
        const avatarFile = editAvatarInput.files[0];
        
        if (avatarFile) {
            // Se um arquivo foi selecionado, converte para Base64
            const reader = new FileReader();
            reader.onload = (event) => {
                const base64String = event.target.result;
                localStorage.setItem('profileAvatar', base64String);
                avatarImg.src = base64String;
                
                // Fecha o modal DEPOIS que a imagem for lida
                closeModal(); 
            };
            reader.readAsDataURL(avatarFile);
        } else {
            // Se nenhum arquivo foi selecionado, apenas fecha o modal
            closeModal();
        }

        Swal.fire({
            title: 'Sucesso!',
            text: 'Seu perfil foi atualizado.',
            icon: 'success',
            confirmButtonColor: '#f07913'
        });
    });

    // 4. Conecta os Event Listeners (Gatilhos)
    editBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    
    // Fecha o modal se clicar fora dele
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // 5. EXECUÇÃO: Carrega os dados assim que a página abre
    loadProfileData();

})