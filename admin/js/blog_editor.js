document.addEventListener('DOMContentLoaded', () => {
    // Live Preview Listeners
    document.getElementById('postTitle').addEventListener('input', updatePreview);
    document.getElementById('postSummary').addEventListener('input', updatePreview);
    document.getElementById('postImage').addEventListener('input', updatePreview);
    document.getElementById('postContent').addEventListener('input', updatePreview);

    // Initial update
    updatePreview();
});

function updatePreview() {
    const title = document.getElementById('postTitle').value || 'Título do Artigo';
    const summary = document.getElementById('postSummary').value || 'Resumo do artigo...';
    const image = document.getElementById('postImage').value;
    const content = document.getElementById('postContent').value || '<p>Conteúdo...</p>';

    document.getElementById('previewTitle').textContent = title;
    document.getElementById('previewSummary').textContent = summary;
    document.getElementById('previewContent').innerHTML = content;

    const hero = document.getElementById('previewHero');
    if (image) {
        hero.style.background = `linear-gradient(rgba(0, 0, 0, 0.664), rgba(0, 0, 0, 0.726)), url('${image}') no-repeat center/cover`;
    } else {
        hero.style.background = `linear-gradient(rgba(0, 0, 0, 0.664), rgba(0, 0, 0, 0.726)), #333`;
    }
}

async function savePost() {
    const title = document.getElementById('postTitle').value;
    const summary = document.getElementById('postSummary').value;
    const image = document.getElementById('postImage').value;
    const content = document.getElementById('postContent').value;

    if (!title || !content) {
        alert('Título e Conteúdo são obrigatórios!');
        return;
    }

    const postData = {
        title,
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
