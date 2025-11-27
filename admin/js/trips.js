document.addEventListener('DOMContentLoaded', () => {
    fetchTrips();
    fetchCurrentUser();

    document.getElementById('searchInput').addEventListener('input', filterTable);
});

let allTrips = [];

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
        const response = await fetch('api/trips.php');
        const data = await response.json();

        if (data.error) {
            console.error('Error:', data.error);
            if (data.error === 'Unauthorized') window.location.href = '../Login/login.php';
            return;
        }

        allTrips = data;
        renderTable(allTrips);

    } catch (error) {
        console.error('Network error:', error);
    }
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

function filterTable(e) {
    const term = e.target.value.toLowerCase();
    const filtered = allTrips.filter(trip =>
        trip.titulo.toLowerCase().includes(term) ||
        (trip.continente && trip.continente.toLowerCase().includes(term))
    );
    renderTable(filtered);
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
