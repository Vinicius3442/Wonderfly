/* =============================================
   ARQUIVO: comunidade_novo.js
   Lógica com Fetch para o fórum da comunidade.
   ============================================= */
// 'baseUrl' e 'isUserLoggedIn' são injetados pelo PHP

document.addEventListener('DOMContentLoaded', () => {

    const threadListContainer = document.getElementById('thread-list-container');
    const startThreadBtn = document.getElementById('start-thread-btn');
    const modal = document.getElementById('new-thread-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    const newThreadForm = document.getElementById('new-thread-form');
    const filterChips = document.querySelectorAll('#board-filter-chips .chip');
    
    // (A lógica do 'seeAllReviewsLink' foi removida, 
    // pois o link agora vai direto para a página de avaliações)

    // 1. LÓGICA DO MODAL (Apenas se o usuário estiver logado)
    if (isUserLoggedIn && modal) {
        function openModal() { modal.classList.add('show'); }
        function closeModal() { modal.classList.remove('show'); }

        startThreadBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    }

    // 2. LÓGICA DE FILTRAGEM (Igual ao JS antigo)
    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            const boardFilter = chip.dataset.board;
            filterThreads(boardFilter);
        });
    });

    function filterThreads(board) {
        const allThreads = document.querySelectorAll('.thread-card');
        let visibleCount = 0;

        const oldPlaceholder = threadListContainer.querySelector('.thread-list-placeholder');
        if (oldPlaceholder) oldPlaceholder.remove();

        allThreads.forEach(thread => {
            if (board === 'all' || thread.dataset.board === board) {
                thread.style.display = 'flex'; 
                visibleCount++;
            } else {
                thread.style.display = 'none';
            }
        });

        if (visibleCount === 0 && allThreads.length > 0) {
            renderPlaceholder("Nenhum tópico encontrado.", "Tente selecionar outra categoria.");
        }
    }

    // 3. LÓGICA DE CARREGAR TÓPICOS (Refatorada com Fetch)
    
    function renderPlaceholder(title, message) {
        threadListContainer.innerHTML = ''; 
        const placeholderHTML = `
        <div class="thread-list-placeholder">
            <i class="ri-discuss-line"></i>
            <h3>${title}</h3>
            <p>${message}</p>
        </div>
        `;
        threadListContainer.insertAdjacentHTML('beforeend', placeholderHTML);
    }

    async function loadAllThreads() {
        try {
            const response = await fetch(`${baseUrl}api/forum_get_topicos.php`);
            if (!response.ok) throw new Error('Falha ao buscar tópicos.');
            
            const result = await response.json();
            
            if (result.success && result.topicos) {
                threadListContainer.innerHTML = ''; // Limpa o "Carregando..."
                
                if (result.topicos.length === 0) {
                    renderPlaceholder("Nenhum tópico por aqui... ainda!", "Seja o primeiro a começar uma conversa.");
                    return;
                }
                
                result.topicos.forEach(thread => {
                    renderThread(thread);
                });
                
                // Reaplica o filtro inicial
                const activeFilter = document.querySelector('#board-filter-chips .chip.active').dataset.board;
                filterThreads(activeFilter);

            } else {
                throw new Error(result.message || 'Erro ao carregar tópicos.');
            }
        } catch (error) {
            renderPlaceholder("Erro de Conexão", error.message);
        }
    }

    function renderThread(thread) {
        const defaultImage = `${baseUrl}images/banner.png`;
        const imageUrl = thread.imagem_url ? (baseUrl + thread.imagem_url) : defaultImage;
        
        const truncatedMessage = thread.mensagem.length > 100 ? thread.mensagem.substring(0, 100) + '...' : thread.mensagem;
        const boardName = thread.board.charAt(0).toUpperCase() + thread.board.slice(1);
        
        // CORRIGIDO: O link agora aponta para 'topico.php'
        const threadUrl = `${baseUrl}Comunidade/topico.php?id=${thread.id}`;

        const cardHTML = `
        <article class="thread-card" data-board="${thread.board}">
            <div class="thread-image">
                <img src="${imageUrl}" alt="${thread.assunto}">
            </div>
            <div class="thread-content">
                <span class="thread-board-badge">${boardName}</span>
                <h3>${thread.assunto}</h3>
                <p class="thread-message">${truncatedMessage}</p>
                <div class="thread-stats">
                    <span><i class="ri-reply-line"></i> ${thread.total_respostas} Respostas</span>
                    <span><i class="ri-user-line"></i> ${thread.autor_nome || 'Anônimo'}</span>
                </div>
                <a href="${threadUrl}" class="btn secondary small">Ver Tópico</a>
            </div>
        </article>
        `;
        threadListContainer.insertAdjacentHTML('beforeend', cardHTML);
    }

    // 4. LÓGICA DE CRIAR NOVO TÓPICO (Refatorada com Fetch)
    if (newThreadForm) {
        newThreadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = newThreadForm.querySelector('button[type="submit"]');

            const formData = new FormData(newThreadForm);

            // Validação simples no frontend
            if (!formData.get('subject') || !formData.get('message')) {
                Swal.fire('Oops!', 'Assunto e Mensagem são obrigatórios.', 'error');
                return;
            }

            submitButton.textContent = 'Publicando...';
            submitButton.disabled = true;

            try {
                const response = await fetch(`${baseUrl}api/forum_criar_topico.php`, {
                    method: 'POST',
                    body: formData // FormData cuida do 'multipart/form-data' para arquivos
                });

                if (!response.ok) throw new Error('Erro na rede.');
                
                const result = await response.json();
                
                if (result.success) {
                    newThreadForm.reset();
                    closeModal();
                    Swal.fire('Sucesso!', 'Seu tópico foi publicado.', 'success');
                    loadAllThreads(); // Recarrega a lista
                } else {
                    throw new Error(result.message || 'Erro ao publicar.');
                }

            } catch (error) {
                Swal.fire('Erro!', error.message, 'error');
            } finally {
                submitButton.textContent = 'Publicar Tópico';
                submitButton.disabled = false;
            }
        });
    }

    // --- Inicialização ---
    loadAllThreads();
});