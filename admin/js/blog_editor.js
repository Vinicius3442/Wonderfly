document.addEventListener('DOMContentLoaded', () => {
    // Live Preview Listeners
    document.getElementById('postTitle').addEventListener('input', updatePreview);
    document.getElementById('postAuthor').addEventListener('input', updatePreview);
    document.getElementById('postSummary').addEventListener('input', updatePreview);
    document.getElementById('postImage').addEventListener('input', updatePreview);
    document.getElementById('postContent').addEventListener('input', updatePreview);

    // Initial update
    updatePreview();
    checkEditMode();
});

async function checkEditMode() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        try {
            const response = await fetch(`api/get_post.php?id=${id}`);
            const data = await response.json();

            if (data.error) {
                alert('Erro ao carregar artigo: ' + data.error);
                return;
            }

            document.getElementById('postTitle').value = data.titulo;
            document.getElementById('postSummary').value = data.resumo;
            document.getElementById('postImage').value = data.imagem_destaque_url;
            document.getElementById('postContent').value = data.conteudo_html;
            // Note: Author is not stored in a separate column for manual name in DB yet, 
            // so we might not be able to populate it unless we stored it. 
            // For now, it defaults to 'Admin' or empty.

            updatePreview();
        } catch (error) {
            console.error('Error fetching post:', error);
        }
    }
}

function updatePreview() {
    const title = document.getElementById('postTitle').value || 'Título do Artigo';
    const author = document.getElementById('postAuthor').value || 'Admin';
    const summary = document.getElementById('postSummary').value || 'Resumo do artigo...';
    const image = document.getElementById('postImage').value;
    const content = document.getElementById('postContent').value || '<p>Conteúdo...</p>';

    document.getElementById('previewTitle').textContent = title;
    document.getElementById('previewSummary').textContent = summary;
    document.getElementById('previewContent').innerHTML = content;

    // Update meta author if exists in preview
    const metaUser = document.querySelector('.article-meta span:nth-child(2)');
    if (metaUser) metaUser.innerHTML = `<i class="ri-user-line"></i> ${author}`;

    const hero = document.getElementById('previewHero');
    if (image) {
        hero.style.background = `linear-gradient(rgba(0, 0, 0, 0.664), rgba(0, 0, 0, 0.726)), url('${image}') no-repeat center/cover`;
    } else {
        hero.style.background = `linear-gradient(rgba(0, 0, 0, 0.664), rgba(0, 0, 0, 0.726)), #333`;
    }
}

async function savePost() {
    const title = document.getElementById('postTitle').value;
    const author = document.getElementById('postAuthor').value;
    const summary = document.getElementById('postSummary').value;
    const image = document.getElementById('postImage').value;
    const content = document.getElementById('postContent').value;

    if (!title || !content) {
        alert('Título e Conteúdo são obrigatórios!');
        return;
    }

    const postData = {
        id: new URLSearchParams(window.location.search).get('id'), // Add ID if editing
        title,
        author,
        summary,
        image,
        content
    };

    try {
        const response = await fetch('api/save_post.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(postData)
        });

        const result = await response.json();

        if (result.success) {
            alert('Artigo salvo com sucesso!');
            window.location.href = 'blog.php';
        } else {
            alert('Erro ao salvar: ' + result.error);
        }
    } catch (error) {
        console.error('Error saving:', error);
        alert('Erro de rede ao salvar.');
    }
}

function toggleFullscreen() {
    const container = document.querySelector('.editor-container');
    container.classList.toggle('fullscreen');

    const icon = document.querySelector('.fullscreen-btn i');
    if (container.classList.contains('fullscreen')) {
        icon.classList.remove('ri-fullscreen-line');
        icon.classList.add('ri-fullscreen-exit-line');
    } else {
        icon.classList.remove('ri-fullscreen-exit-line');
        icon.classList.add('ri-fullscreen-line');
    }
}

// Ensure global access
window.toggleFullscreen = toggleFullscreen;
