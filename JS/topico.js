/* =============================================
   ARQUIVO: topico.js
   Lógica para a página de um único tópico.
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    // --- Seletores ---
    const opContainer = document.getElementById('original-post-container');
    const repliesContainer = document.getElementById('replies-list-container');
    const replyForm = document.getElementById('reply-form');
    const replyCountEl = document.getElementById('reply-count');
    const replyMessageInput = document.getElementById('reply-message');

    // --- Constante do LocalStorage ---
    const STORAGE_KEY = 'wonderflyThreads';

    // --- Estado ---
    let currentTopic = null; // Armazena o tópico atual

    // ===================================
    // 1. FUNÇÕES DE DADOS (LocalStorage)
    // ===================================
    
    // Pega todos os tópicos
    function getThreads() {
        return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    }
    // Salva todos os tópicos
    function saveThreads(threads) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(threads));
    }
    
    // Pega o ID do tópico da URL
    function getTopicIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return parseInt(params.get('id'), 10);
    }

    // Busca um tópico específico pelo ID
    function findTopicById(topicId) {
        const threads = getThreads();
        return threads.find(thread => thread.id === topicId);
    }

    // ===================================
    // 2. FUNÇÕES DE RENDERIZAÇÃO
    // ===================================
    
    // Renderiza a Postagem Original (OP)
    function renderOriginalPost(topic) {
        if (!topic) {
            opContainer.innerHTML = '<div class="op-loading"><h2>Tópico não encontrado!</h2><a href="./comunidade.html">Voltar</a></div>';
            return;
        }
        
        document.title = `WonderFly - ${topic.subject}`;

        const defaultImage = "../images/banner.png";
        const imageUrl = topic.image || defaultImage;
        const boardName = topic.board.charAt(0).toUpperCase() + topic.board.slice(1);
        const postDate = new Date(topic.createdAt).toLocaleDateString('pt-BR');

        // Adicionado "data-board" para o CSS colorir o badge
        // Adicionado botão de apagar com id "delete-topic-btn"
        const opHTML = `
        <article class="original-post" data-id="${topic.id}" data-board="${topic.board}"> 
            <header class="op-header">
                <span class="thread-board-badge">${boardName}</span>
                <h1>${topic.subject}</h1>
                <div class="op-meta">
                    <div>Postado por <strong>Usuário Anônimo</strong> em ${postDate}</div>
                    <button class="btn-delete-topic" id="delete-topic-btn" title="Apagar este tópico">
                        <i class="ri-delete-bin-line"></i> Apagar Tópico
                    </button>
                </div>
            </header>
            <div class="op-body">
                ${topic.image ? `<img src="${topic.image}" alt="${topic.subject}" class="op-image">` : ''}
                <p>${topic.message}</p>
            </div>
        </article>
        `;
        opContainer.innerHTML = opHTML;

        // --- NOVO: Listener para o botão de apagar ---
        // Adiciona o listener DEPOIS de inserir o HTML na página
        const deleteBtn = document.getElementById('delete-topic-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                // Passa o ID do tópico atual para a função de apagar
                handleDeleteTopic(topic.id);
            });
        }
    }

    // Renderiza a lista de respostas
    function renderReplies(replies) {
        repliesContainer.innerHTML = ''; 
        
        replyCountEl.textContent = `Respostas (${replies.length})`;

        if (replies.length === 0) {
            repliesContainer.innerHTML = '<div class="reply-card no-replies">Ainda não há respostas. Seja o primeiro a comentar!</div>';
            return;
        }

        replies.forEach(reply => {
            const replyDate = new Date(reply.createdAt).toLocaleDateString('pt-BR');
            const avatar = '../images/profile/avatar-default.jpg'; 

            const replyHTML = `
            <article class="reply-card">
                <div class="reply-user">
                    <img src="${avatar}" alt="Avatar">
                    <strong>Usuário Anônimo</strong>
                    <span class="reply-date"> - ${replyDate}</span>
                </div>
                <p>${reply.message}</p>
            </article>
            `;
            repliesContainer.insertAdjacentHTML('beforeend', replyHTML);
        });
    }

    // ===================================
    // 3. LÓGICA DE AÇÕES (Responder / Apagar)
    // ===================================
    
    replyForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const message = replyMessageInput.value;
        if (!message.trim()) {
            Swal.fire('Oops!', 'Você não pode publicar uma resposta vazia.', 'error');
            return;
        }
        
        const newReply = {
            id: Date.now(),
            message: message,
            createdAt: new Date().toISOString()
        };

        const allThreads = getThreads();
        const topicIndex = allThreads.findIndex(t => t.id === currentTopic.id);
        
        if (topicIndex > -1) {
            allThreads[topicIndex].replies.push(newReply);
            saveThreads(allThreads);
            currentTopic = allThreads[topicIndex];
            renderReplies(currentTopic.replies);
            replyMessageInput.value = '';
            
            Swal.fire({
                title: 'Sucesso!',
                text: 'Sua resposta foi publicada.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                confirmButtonColor: '#f07913'
            });
        } else {
            Swal.fire('Erro!', 'Não foi possível encontrar este tópico para salvar sua resposta.', 'error');
        }
    });

    // --- NOVA FUNÇÃO PARA APAGAR TÓPICO ---
    function handleDeleteTopic(topicId) {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você não poderá reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f07913', // Laranja
            cancelButtonColor: '#555',     // Cinza
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Se o usuário confirmar...
            if (result.isConfirmed) {
                // 1. Pega todos os tópicos
                const allThreads = getThreads();
                
                // 2. Filtra o array, mantendo TODOS exceto o que tem o topicId
                const updatedThreads = allThreads.filter(thread => thread.id !== topicId);
                
                // 3. Salva o novo array (sem o tópico apagado) no localStorage
                saveThreads(updatedThreads);

                // 4. Feedback de sucesso e redirecionamento
                Swal.fire(
                    'Apagado!',
                    'Seu tópico foi removido.',
                    'success'
                ).then(() => {
                    // 5. Redireciona para a home da comunidade
                    window.location.href = './home_comunidade.html';
                });
            }
        });
    }


    // ===================================
    // 4. INICIALIZAÇÃO DA PÁGINA
    // ===================================
    function init() {
        opContainer.innerHTML = '<div class="op-loading"><h2>Carregando tópico...</h2></div>';
        
        const topicId = getTopicIdFromUrl();
        if (!topicId) {
            opContainer.innerHTML = '<div class="op-loading"><h2>ID do tópico não fornecido!</h2><a href="./comunidade.html">Voltar</a></div>';
            return;
        }
        
        currentTopic = findTopicById(topicId);
        
        if (currentTopic) {
            renderOriginalPost(currentTopic);
            renderReplies(currentTopic.replies);
        } else {
            renderOriginalPost(null); // Mostra "Tópico não encontrado"
            repliesContainer.style.display = 'none'; 
            replyForm.style.display = 'none';
        }
    }

    init();

}); // Fim do DOMContentLoaded