/* =============================================
   ARQUIVO: comunidade.js
   Lógica para o fórum da comunidade.
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    // --- Seletores Principais ---
    const threadListContainer = document.getElementById('thread-list-container');
    const startThreadBtn = document.getElementById('start-thread-btn');
    const modal = document.getElementById('new-thread-modal');
    const closeBtn = document.getElementById('modal-close-btn');
    const newThreadForm = document.getElementById('new-thread-form');
    const filterChips = document.querySelectorAll('#board-filter-chips .chip');

    // --- Constante do LocalStorage ---
    const STORAGE_KEY = 'wonderflyThreads';

    // ===================================
    // 1. LÓGICA DO MODAL
    // ===================================
    function openModal() { modal.classList.add('show'); }
    function closeModal() { modal.classList.remove('show'); }

    startThreadBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // ===================================
    // 2. LÓGICA DE FILTRAGEM
    // ===================================
    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            // Atualiza o estado ativo do chip
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');

            const boardFilter = chip.dataset.board;
            filterThreads(boardFilter);
        });
    });

    function filterThreads(board) {
        const allThreads = document.querySelectorAll('.thread-card');
        allThreads.forEach(thread => {
            if (board === 'all' || thread.dataset.board === board) {
                thread.style.display = 'flex'; // 'flex' porque usamos flex-direction
            } else {
                thread.style.display = 'none';
            }
        });
    }

    // ===================================
    // 3. LÓGICA DE CARREGAR TÓPICOS
    // ===================================
    
    // Pega os tópicos do localStorage
    function getThreads() {
        return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    }

    // Salva os tópicos no localStorage
    function saveThreads(threads) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(threads));
    }

    // Carrega e exibe todos os tópicos na página
    function loadAllThreads() {
        threadListContainer.innerHTML = ''; // Limpa a lista
        const threads = getThreads();
        // Exibe os mais novos primeiro
        threads.reverse().forEach(thread => {
            renderThread(thread);
        });
        // Reaplica o filtro atual (caso 'Todos' não esteja selecionado)
        const activeFilter = document.querySelector('#board-filter-chips .chip.active').dataset.board;
        filterThreads(activeFilter);
    }

    // Cria o HTML de um único tópico e o insere na página
    function renderThread(thread) {
        // Fallback de imagem (se o usuário não enviar uma)
        const defaultImage = "../images/banner.png";
        const imageUrl = thread.image || defaultImage;
        
        // Trunca a mensagem para o card
        const truncatedMessage = thread.message.length > 100 ? thread.message.substring(0, 100) + '...' : thread.message;

        // Capitaliza a primeira letra da categoria
        const boardName = thread.board.charAt(0).toUpperCase() + thread.board.slice(1);
        
        // O `href` aponta para uma futura página de tópico
        // Passando o ID do tópico na URL (ex: ?id=12345)
        const threadUrl = `topico.html?id=${thread.id}`;

        const cardHTML = `
        <article class="thread-card" data-board="${thread.board}">
            <div class="thread-image">
                <img src="${imageUrl}" alt="${thread.subject}">
            </div>
            <div class="thread-content">
                <span class="thread-board-badge">${boardName}</span>
                <h3>${thread.subject}</h3>
                <p class="thread-message">${truncatedMessage}</p>
                <div class="thread-stats">
                    <span><i class="ri-reply-line"></i> ${thread.replies.length} Respostas</span>
                </div>
                <a href="${threadUrl}" class="btn secondary small">Ver Tópico</a>
            </div>
        </article>
        `;
        // Usamos insertAdjacentHTML para adicionar no início
        threadListContainer.insertAdjacentHTML('beforeend', cardHTML);
    }

    // ===================================
    // 4. LÓGICA DE CRIAR NOVO TÓPICO
    // ===================================
    newThreadForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Pega os valores do formulário
        const board = document.getElementById('thread-board').value;
        const subject = document.getElementById('thread-subject').value;
        const message = document.getElementById('thread-message').value;
        const imageFile = document.getElementById('thread-image').files[0];

        if (!subject || !message) {
            Swal.fire('Oops!', 'Assunto e Mensagem são obrigatórios.', 'error');
            return;
        }

        const reader = new FileReader();

        // O que fazer DEPOIS que a imagem for lida
        reader.onload = (event) => {
            const imageUrl = event.target.result; // Imagem em Base64
            
            const newThread = {
                id: Date.now(), // ID único baseado no tempo
                board: board,
                subject: subject,
                message: message,
                image: imageUrl,
                replies: [], // Um array vazio para futuras respostas
                createdAt: new Date().toISOString()
            };

            // Salva no localStorage
            const threads = getThreads();
            threads.push(newThread);
            saveThreads(threads);

            // Adiciona na página (sem recarregar)
            loadAllThreads(); 

            // Limpa e fecha o modal
            newThreadForm.reset();
            closeModal();

            Swal.fire({
                title: 'Sucesso!',
                text: 'Seu tópico foi publicado.',
                icon: 'success',
                confirmButtonColor: '#f07913'
            });
        };

        // Se o usuário enviou uma imagem, leia-a.
        if (imageFile) {
            reader.readAsDataURL(imageFile);
        } else {
            // Se não, execute o 'onload' manualmente com 'null'
            reader.onload({ target: { result: null } });
        }
    });

    // --- Inicialização ---
    loadAllThreads();

}); // Fim do DOMContentLoaded