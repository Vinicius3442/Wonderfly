/* =============================================
   ARQUIVO: topico_novo.js
   Lógica com Fetch para um único tópico.
   ============================================= */
// 'baseUrl', 'isUserLoggedIn', 'currentUserId' são injetados pelo PHP

document.addEventListener('DOMContentLoaded', () => {

    const opContainer = document.getElementById('original-post-container');
    const repliesContainer = document.getElementById('replies-list-container');
    const replyForm = document.getElementById('reply-form');
    const replyCountEl = document.getElementById('reply-count');
    const replyMessageInput = document.getElementById('reply-message');

    let currentTopic = null; // Armazena o tópico atual

    // 1. FUNÇÕES DE DADOS (Fetch)
    
    function getTopicIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return parseInt(params.get('id'), 10);
    }

    async function fetchTopicData(topicId) {
        try {
            const response = await fetch(`${baseUrl}api/forum_get_detalhes.php?id=${topicId}`);
            if (!response.ok) throw new Error('Falha ao buscar dados do tópico.');
            
            const result = await response.json();
            if (result.success) {
                return result; // Retorna { topico: {...}, respostas: [...] }
            } else {
                throw new Error(result.message || 'Tópico não encontrado.');
            }
        } catch (error) {
            renderOriginalPost(null, error.message);
            return null;
        }
    }

    // 2. FUNÇÕES DE RENDERIZAÇÃO
    
    function renderOriginalPost(topic, errorMsg = null) {
        if (!topic) {
            opContainer.innerHTML = `<div class="op-loading"><h2>${errorMsg || 'Tópico não encontrado!'}</h2><a href="${baseUrl}Comunidade/home_comunidade.php">Voltar</a></div>`;
            return;
        }
        
        document.title = `WonderFly - ${topic.assunto}`;

        const defaultImage = `${baseUrl}images/banner.png`;
        const imageUrl = topic.imagem_url ? (baseUrl + topic.imagem_url) : null;
        const boardName = topic.board.charAt(0).toUpperCase() + topic.board.slice(1);
        const postDate = new Date(topic.data_criacao).toLocaleString('pt-BR');
        const autorNome = topic.autor_nome || 'Usuário Anônimo';

        // (TODO: Lógica de apagar/editar)
        const canDelete = isUserLoggedIn && (currentUserId === topic.usuario_id);

        const opHTML = `
        <article class="original-post" data-id="${topic.id}" data-board="${topic.board}"> 
            <header class="op-header">
                <span class="thread-board-badge">${boardName}</span>
                <h1>${topic.assunto}</h1>
                <div class="op-meta">
                    <div>Postado por <strong>${autorNome}</strong> em ${postDate}</div>
                    ${canDelete ? `
                    <button class="btn-delete-topic" id="delete-topic-btn" title="Apagar este tópico">
                        <i class="ri-delete-bin-line"></i> Apagar Tópico
                    </button>` : ''}
                </div>
            </header>
            <div class="op-body">
                ${imageUrl ? `<img src="${imageUrl}" alt="${topic.assunto}" class="op-image">` : ''}
                <p>${nl2br(topic.mensagem)}</p> </div>
        </article>
        `;
        opContainer.innerHTML = opHTML;

        // (Lógica de apagar - ainda não implementada no backend)
        const deleteBtn = document.getElementById('delete-topic-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => handleDeleteTopic(topic.id));
        }
    }

    function renderReplies(replies) {
        repliesContainer.innerHTML = ''; 
        replyCountEl.textContent = `Respostas (${replies.length})`;

        if (replies.length === 0) {
            repliesContainer.innerHTML = '<div class="reply-card no-replies">Ainda não há respostas. Seja o primeiro a comentar!</div>';
            return;
        }

        replies.forEach(reply => {
            renderSingleReply(reply);
        });
    }

    // Helper para renderizar UMA resposta (usado no load e no submit)
    function renderSingleReply(reply) {
        const replyDate = new Date(reply.data_criacao).toLocaleString('pt-BR');
        const autorNome = reply.autor_nome || 'Usuário Anônimo';
        const avatar = (reply.autor_avatar && reply.autor_avatar !== '/images/profile/avatar-default.jpg') 
                       ? (baseUrl + reply.autor_avatar) 
                       : `${baseUrl}images/profile/avatar-default.jpg`; 

        const replyHTML = `
        <article class="reply-card">
            <div class="reply-user">
                <img src="${avatar}" alt="Avatar">
                <strong>${autorNome}</strong>
                <span class="reply-date"> - ${replyDate}</span>
            </div>
            <p>${nl2br(reply.mensagem)}</p>
        </article>
        `;
        repliesContainer.insertAdjacentHTML('beforeend', replyHTML);
    }
    
    // Helper para converter \n em <br>
    function nl2br(str) {
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
    }

    // 3. LÓGICA DE AÇÕES (Responder / Apagar)
    
    if (replyForm) {
        replyForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = replyMessageInput.value;
            if (!message.trim()) {
                Swal.fire('Oops!', 'Você não pode publicar uma resposta vazia.', 'error');
                return;
            }
            
            const submitButton = replyForm.querySelector('button[type="submit"]');
            submitButton.textContent = 'Publicando...';
            submitButton.disabled = true;

            try {
                const response = await fetch(`${baseUrl}api/forum_add_resposta.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        topico_id: currentTopic.id,
                        message: message
                    })
                });
                
                if (!response.ok) throw new Error('Erro na rede.');
                
                const result = await response.json();
                
                if (result.success && result.resposta) {
                    // Limpa o placeholder (se for a primeira resposta)
                    const noReplies = repliesContainer.querySelector('.no-replies');
                    if (noReplies) noReplies.remove();
                    
                    renderSingleReply(result.resposta); // Adiciona a nova resposta
                    replyMessageInput.value = '';
                    replyCountEl.textContent = `Respostas (${repliesContainer.children.length})`;
                } else {
                    throw new Error(result.message || 'Erro ao publicar resposta.');
                }
                
            } catch (error) {
                Swal.fire('Erro!', error.message, 'error');
            } finally {
                submitButton.textContent = 'Publicar Resposta';
                submitButton.disabled = false;
            }
        });
    }

    function handleDeleteTopic(topicId) {
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Esta ação é irreversível e apagará todas as respostas!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e63946', // Um vermelho mais forte para delete
            cancelButtonColor: '#555',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Se o usuário confirmar...
            if (result.isConfirmed) {
                // Chama a função que executa a deleção
                executeDelete(topicId);
            }
        });
    }

    async function executeDelete(topicId) {
        try {
            const response = await fetch(`${baseUrl}api/forum_delete_topico.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: topicId })
            });

            if (!response.ok) throw new Error('Erro na resposta da rede.');

            const result = await response.json();

            if (result.success) {
                // 4. Feedback de sucesso e redirecionamento
                await Swal.fire(
                    'Apagado!',
                    'Seu tópico foi removido.',
                    'success'
                );
                // 5. Redireciona para a home da comunidade
                window.location.href = `${baseUrl}Comunidade/home_comunidade.php`;
            } else {
                // Falha (ex: não é o dono do post)
                throw new Error(result.message || 'Erro ao apagar.');
            }

        } catch (error) {
            Swal.fire('Erro!', error.message, 'error');
        }
    }

    // 4. INICIALIZAÇÃO DA PÁGINA
    async function init() {
        const topicId = getTopicIdFromUrl();
        if (!topicId) {
            renderOriginalPost(null, 'ID do tópico não fornecido!');
            return;
        }
        
        const data = await fetchTopicData(topicId);
        
        if (data && data.topico) {
            currentTopic = data.topico; // Salva o tópico atual
            renderOriginalPost(data.topico);
            renderReplies(data.respostas);
        } else {
            // O erro já foi renderizado por fetchTopicData
            repliesContainer.style.display = 'none'; 
            if(replyForm) replyForm.style.display = 'none';
        }
    }

    init();
});