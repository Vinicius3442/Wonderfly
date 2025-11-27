document.addEventListener('DOMContentLoaded', () => {
    fetchPosts();
    fetchCurrentUser(); // Reuse logic or create a shared utility? For now, I'll duplicate simple fetch

    document.getElementById('searchInput').addEventListener('input', filterTable);
});

let allPosts = [];

async function fetchCurrentUser() {
    try {
        const response = await fetch('api/stats.php'); // Reusing stats endpoint for user info
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
        const response = await fetch('api/blog_posts.php');
        const data = await response.json();

        if (data.error) {
            console.error('Error:', data.error);
            if (data.error === 'Unauthorized') window.location.href = '../Login/login.php';
            return;
        }

        allPosts = data;
        renderTable(allPosts);

    } catch (error) {
        console.error('Network error:', error);
    }
}

function renderTable(posts) {
    const tbody = document.getElementById('blogTableBody');
    tbody.innerHTML = '';

    posts.forEach(post => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>#${post.id}</td>
            <td class="fw-bold">${post.titulo}</td>
            <td>${post.autor || 'Desconhecido'}</td>
            <td>${new Date(post.data_publicacao).toLocaleDateString('pt-BR')}</td>
            <td class="actions-cell">
                <a href="blog_editor.php?id=${post.id}" class="btn-icon edit" title="Editar">
                    <i class="ri-pencil-line"></i>
                </a>
                <button onclick="deletePost(${post.id})" class="btn-icon delete" title="Excluir">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function filterTable(e) {
    const term = e.target.value.toLowerCase();
    const filtered = allPosts.filter(post =>
        post.titulo.toLowerCase().includes(term) ||
        (post.autor && post.autor.toLowerCase().includes(term))
    );
    renderTable(filtered);
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
