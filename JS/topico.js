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
        // Usamos parseInt para garantir que o ID seja um número
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
        
        // Define o título da página
        document.title = `WonderFly - ${topic.subject}`;

        const defaultImage = "../images/banner.png";
        const imageUrl = topic.image || defaultImage;
        const boardName = topic.board.charAt(0).toUpperCase() + topic.board.slice(1);
        const postDate = new Date(topic.createdAt).toLocaleDateString('pt-BR');

        const opHTML = `
        <article class="original-post" data-id="${topic.id}">
            <header class="op-header">
                <span class="thread-board-badge">${boardName}</span>
                <h1>${topic.subject}</h1>
                <div class="op-meta">
                    Postado por <strong>Usuário Anônimo</strong> em ${postDate}
                </div>
            </header>
            <div class="op-body">
                ${topic.image ? `<img src="${topic.image}" alt="${topic.subject}" class="op-image">` : ''}
                <p>${topic.message}</p>
            </div>
        </article>
        `;
        opContainer.innerHTML = opHTML;
    }

    // Renderiza a lista de respostas
    function renderReplies(replies) {
        repliesContainer.innerHTML = ''; // Limpa a lista
        
        // Atualiza a contagem
        replyCountEl.textContent = `Respostas (${replies.length})`;

        if (replies.length === 0) {
            repliesContainer.innerHTML = '<div class="reply-card no-replies">Ainda não há respostas. Seja o primeiro a comentar!</div>';
            return;
        }

        // Mostra as mais antigas primeiro
        replies.forEach(reply => {
            const replyDate = new Date(reply.createdAt).toLocaleDateString('pt-BR');
            // Usamos um avatar padrão, pois ainda não temos login
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
    // 3. LÓGICA DE NOVA RESPOSTA
    // ===================================
    replyForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const message = replyMessageInput.value;
        if (!message.trim()) {
            Swal.fire('Oops!', 'Você não pode publicar uma resposta vazia.', 'error');
            return;
        }
        
        // Cria o objeto da nova resposta
        const newReply = {
            id: Date.now(),
            message: message,
            createdAt: new Date().toISOString()
            // (Poderia adicionar 'user' se tivéssemos login)
        };

        // Atualiza o localStorage
        const allThreads = getThreads();
        // Encontra o tópico que estamos vendo
        const topicIndex = allThreads.findIndex(t => t.id === currentTopic.id);
        
        if (topicIndex > -1) {
            // Adiciona a nova resposta ao array de respostas do tópico
            allThreads[topicIndex].replies.push(newReply);
            
            // Salva a estrutura de tópicos inteira de volta no localStorage
            saveThreads(allThreads);

            // Atualiza o objeto 'currentTopic'
            currentTopic = allThreads[topicIndex];
            
            // Re-renderiza as respostas na tela (sem recarregar a página)
            renderReplies(currentTopic.replies);

            // Limpa o formulário
            replyMessageInput.value = '';
            
            // Feedback de sucesso
            Swal.fire({
                title: 'Sucesso!',
                text: 'Sua resposta foi publicada.',
                icon: 'success',
                timer: 1500, // Fecha sozinho
                showConfirmButton: false,
                confirmButtonColor: '#f07913'
            });

        } else {
            Swal.fire('Erro!', 'Não foi possível encontrar este tópico para salvar sua resposta.', 'error');
        }
    });

    // =D=================================
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
            repliesContainer.style.display = 'none'; // Esconde a seção de respostas
            replyForm.style.display = 'none';
        }
    }

    init();

}); // Fim do DOMContentLoaded