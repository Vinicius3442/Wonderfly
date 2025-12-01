document.addEventListener('DOMContentLoaded', () => {
    fetchTrips();
    fetchCurrentUser();
    setupPaginationListeners();
});

let currentPage = 1;
let limit = 10;
let sort = 'id';
let order = 'ASC';
let allTrips = [];

function setupPaginationListeners() {
    const prevBtn = document.getElementById('prevPage');
    const nextBtn = document.getElementById('nextPage');
    const limitSelect = document.getElementById('limitSelect');
    const searchInput = document.getElementById('searchInput');

    if (prevBtn) prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            fetchTrips();
        }
    });

    if (nextBtn) nextBtn.addEventListener('click', () => {
        currentPage++;
        fetchTrips();
    });

    if (limitSelect) limitSelect.addEventListener('change', (e) => {
        limit = parseInt(e.target.value);
        currentPage = 1;
        fetchTrips();
    });

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            const filtered = allTrips.filter(trip =>
                trip.titulo.toLowerCase().includes(term) ||
                (trip.continente && trip.continente.toLowerCase().includes(term))
            );
            renderTable(filtered);
        });
    }

    // Sorting
    const headers = document.querySelectorAll('th[data-sort]');
    headers.forEach(th => {
        th.style.cursor = 'pointer';
        th.addEventListener('click', () => {
            const newSort = th.dataset.sort;
            if (sort === newSort) {
                order = order === 'ASC' ? 'DESC' : 'ASC';
            } else {
                sort = newSort;
                order = 'ASC';
            }
            // Update icons
            headers.forEach(h => h.querySelector('i')?.remove());
            const icon = document.createElement('i');
            icon.className = order === 'ASC' ? 'ri-arrow-up-s-fill' : 'ri-arrow-down-s-fill';
            th.appendChild(icon);

            fetchTrips();
        });
    });
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

async function fetchTrips() {
    try {
        // Remove search param from server call
        const response = await fetch(`api/trips.php?page=${currentPage}&limit=${limit}&sort=${sort}&order=${order}`);
        const result = await response.json();

        if (result.error) {
            console.error('Error:', result.error);
            if (result.error === 'Unauthorized') window.location.href = '../Login/login.php';
            return;
        }

        const trips = result.data;
        const pagination = result.pagination;

        allTrips = trips; // Update global for client-side filtering

        // Re-apply search filter if there is text in the input
        const searchInput = document.getElementById('searchInput');
        if (searchInput && searchInput.value) {
            const term = searchInput.value.toLowerCase();
            const filtered = allTrips.filter(trip =>
                trip.titulo.toLowerCase().includes(term) ||
                (trip.continente && trip.continente.toLowerCase().includes(term))
            );
            renderTable(filtered);
        } else {
            renderTable(trips);
        }

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

function renderTable(trips) {
    const tbody = document.getElementById('tripsTableBody');
    tbody.innerHTML = '';

    trips.forEach(trip => {
        const tr = document.createElement('tr');
        const price = parseFloat(trip.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        tr.innerHTML = `
            <td>#${trip.id}</td>
            <td class="fw-bold">${trip.titulo}</td>
            <td>${capitalize(trip.continente)}</td>
            <td>${price}</td>
            <td>${trip.duracao}</td>
            <td class="actions-cell">
                <a href="trip_editor.php?id=${trip.id}" class="btn-icon edit" title="Editar">
                    <i class="ri-pencil-line"></i>
                </a>
                <button onclick="deleteTrip(${trip.id})" class="btn-icon delete" title="Excluir">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function capitalize(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

async function deleteTrip(id) {
    if (!confirm('Tem certeza que deseja excluir esta viagem?')) return;

    try {
        const response = await fetch('api/trips.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await response.json();

        if (result.success) {
            fetchTrips(); // Reload table
        } else {
            alert('Erro ao excluir: ' + (result.error || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Error deleting:', error);
    }
}

function exportCSV() {
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Titulo,Continente,Preco,Duracao\n";

    allTrips.forEach(trip => {
        const row = [
            trip.id,
            `"${trip.titulo.replace(/"/g, '""')}"`,
            trip.continente,
            trip.preco,
            trip.duracao
        ].join(",");
        csvContent += row + "\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "viagens.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Relatório de Viagens", 14, 15);

    const tableColumn = ["ID", "Título", "Continente", "Preço", "Duração"];
    const tableRows = [];

    allTrips.forEach(trip => {
        const price = parseFloat(trip.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        const tripData = [
            trip.id,
            trip.titulo,
            trip.continente,
            price,
            trip.duracao
        ];
        tableRows.push(tripData);
    });

    doc.autoTable({
        head: [tableColumn],
        body: tableRows,
        startY: 20,
    });

    doc.save("viagens.pdf");
}
