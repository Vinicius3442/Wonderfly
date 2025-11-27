document.addEventListener('DOMContentLoaded', () => {
    fetchPosts();
    fetchCurrentUser();
    setupPaginationListeners();
    document.getElementById('searchInput').addEventListener('input', filterGrid);
});

let currentPage = 1;
let limit = 10;
let sort = 'data_publicacao';
let order = 'DESC';
let allPosts = [];

function setupPaginationListeners() {
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const limitSelect = document.getElementById('limitSelect');

    if (prevBtn) prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            fetchPosts();
        }
    });

    if (nextBtn) nextBtn.addEventListener('click', () => {
        currentPage++;
        fetchPosts();
    });

    if (limitSelect) limitSelect.addEventListener('change', (e) => {
        limit = parseInt(e.target.value);
        currentPage = 1;
        fetchPosts();
    });

    // Sorting is now handled by changeSort() and toggleOrder()
}

function changeSort() {
    sort = document.getElementById('sortSelect').value;
    currentPage = 1;
    fetchPosts();
}

function toggleOrder() {
    order = order === 'ASC' ? 'DESC' : 'ASC';
    const icon = document.getElementById('orderIcon');
    icon.className = order === 'ASC' ? 'ri-arrow-up-line' : 'ri-arrow-down-line';
    fetchPosts();
}

async function fetchCurrentUser() {
    try {
        const response = await fetch('api/stats.php');
        const data = await response.json();
        if (data.current_user) {
            updateUserProfile(data.current_user);
        }
    } catch (error) {
        console.error('Error fetching user:', error);
    }
}

function updateUserProfile(user) {
    if (user) {
        document.getElementById('admin-name').textContent = user.name;
        let avatarPath = user.avatar;
        if (avatarPath && !avatarPath.startsWith('http') && !avatarPath.startsWith('/')) {
            avatarPath = '../' + avatarPath;
        }
        document.getElementById('admin-avatar').src = avatarPath || '../images/profile/default.jpg';
    }
}

async function fetchPosts() {
    try {
        const response = await fetch(`api/blog_posts.php?page=${currentPage}&limit=${limit}&sort=${sort}&order=${order}`);
        const result = await response.json();

        if (result.error) {
            console.error('Error:', result.error);
            if (result.error === 'Unauthorized') window.location.href = '../Login/login.php';
            return;
        }

        const posts = result.data;
        const pagination = result.pagination;

        allPosts = posts; // Update for export (current page only)
        renderGrid(posts);
        updatePaginationUI(pagination);

    } catch (error) {
        console.error('Network error:', error);
    }
}

function updatePaginationUI(pagination) {
    document.getElementById('currentPage').textContent = pagination.current_page;
    document.getElementById('totalItems').textContent = pagination.total_items;

    const start = (pagination.current_page - 1) * pagination.limit + 1;
    const end = Math.min(start + pagination.limit - 1, pagination.total_items);

    document.getElementById('startItem').textContent = pagination.total_items > 0 ? start : 0;
    document.getElementById('endItem').textContent = end;

    document.getElementById('prevPage').disabled = pagination.current_page <= 1;
    document.getElementById('nextPage').disabled = pagination.current_page >= pagination.total_pages;
}

function renderGrid(posts) {
    const container = document.getElementById('blogGrid');
    container.innerHTML = '';

    if (posts.length === 0) {
        container.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">Nenhum artigo encontrado.</p>';
        return;
    }

    posts.forEach(post => {
        const div = document.createElement('div');
        div.className = 'blog-card';

        // Use default image if none provided
        const image = post.imagem_destaque_url || '../images/placeholder-blog.jpg';

        div.innerHTML = `
            <img src="${image}" alt="${post.titulo}" class="blog-card-image">
            <div class="blog-card-content">
                <div class="blog-card-meta">
                    <span><i class="ri-calendar-line"></i> ${new Date(post.data_publicacao).toLocaleDateString('pt-BR')}</span>
                    <span>#${post.id}</span>
                </div>
                <h3 class="blog-card-title">${post.titulo}</h3>
                
                <div class="blog-card-author">
                    <div style="flex:1">
                        <span style="display:block; font-size: 0.75rem; color: var(--text-muted);">Autor</span>
                        <span style="color: var(--text-light); font-weight: 500;">${post.autor || 'Desconhecido'}</span>
                    </div>
                    
                    <div class="blog-card-actions">
                        <a href="blog_editor.php?id=${post.id}" title="Editar">
                            <i class="ri-pencil-line"></i>
                        </a>
                        <button onclick="deletePost(${post.id})" class="delete" title="Excluir">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}

function filterGrid(e) {
    const term = e.target.value.toLowerCase();
    const filtered = allPosts.filter(post =>
        post.titulo.toLowerCase().includes(term) ||
        (post.autor && post.autor.toLowerCase().includes(term))
    );
    renderGrid(filtered);
}

async function deletePost(id) {
    if (!confirm('Tem certeza que deseja excluir este artigo?')) return;

    try {
        const response = await fetch('api/blog_posts.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await response.json();

        if (result.success) {
            fetchPosts(); // Reload table
        } else {
            alert('Erro ao excluir: ' + (result.error || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Error deleting:', error);
    }
}

function exportCSV() {
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Titulo,Autor,Data\n";

    allPosts.forEach(post => {
        const row = [
            post.id,
            `"${post.titulo.replace(/"/g, '""')}"`, // Escape quotes
            post.autor,
            post.data_publicacao
        ].join(",");
        csvContent += row + "\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "blog_posts.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Relatório de Artigos do Blog", 14, 15);

    const tableColumn = ["ID", "Título", "Autor", "Data"];
    const tableRows = [];

    allPosts.forEach(post => {
        const postData = [
            post.id,
            post.titulo,
            post.autor,
            new Date(post.data_publicacao).toLocaleDateString('pt-BR')
        ];
        tableRows.push(postData);
    });

    doc.autoTable({
        head: [tableColumn],
        body: tableRows,
        startY: 20,
    });

    doc.save("blog_posts.pdf");
}
