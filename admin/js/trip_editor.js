document.addEventListener('DOMContentLoaded', () => {
    initMap();
    initPreviewListeners();
    checkEditMode();
});

let map;
let markers = [];
let locations = []; // Array of {name, lat, lng}

// State for builders
let itineraryDays = [];
let includedItems = [];
let notIncludedItems = [];
let accommodations = [];

function initMap() {
    map = L.map('mapEditor').setView([-15.7801, -47.9292], 3);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    map.on('click', onMapClick);
}

function onMapClick(e) {
    const name = prompt("Nome do local (ex: Rio de Janeiro):");
    if (name) {
        addLocation(name, e.latlng.lat, e.latlng.lng);
    }
}

function addLocation(name, lat, lng) {
    const location = { name, lat, lng };
    locations.push(location);
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup(name).openPopup();
    markers.push(marker);
    renderLocationsList();
}

function removeLocation(index) {
    locations.splice(index, 1);
    map.removeLayer(markers[index]);
    markers.splice(index, 1);
    renderLocationsList();
}

function renderLocationsList() {
    const list = document.getElementById('locationsList');
    list.innerHTML = '';
    locations.forEach((loc, index) => {
        const div = document.createElement('div');
        div.className = 'location-item';
        div.innerHTML = `
            <span>${loc.name}</span>
            <button onclick="removeLocation(${index})"><i class="ri-delete-bin-line"></i></button>
        `;
        list.appendChild(div);
    });
}

// --- BUILDER FUNCTIONS ---

function addItineraryDay(title = '', desc = '') {
    const container = document.getElementById('itineraryList');
    const dayIndex = container.children.length + 1;

    const div = document.createElement('div');
    div.className = 'builder-item form-group';
    div.innerHTML = `
        <button class="remove-btn" onclick="this.parentElement.remove(); updatePreview();"><i class="ri-delete-bin-line"></i></button>
        <label>Dia ${dayIndex}</label>
        <input type="text" class="day-title" placeholder="Título do dia (ex: Chegada em Teerã)" value="${title}">
        <textarea class="day-desc" placeholder="Descrição das atividades...">${desc}</textarea>
    `;
    container.appendChild(div);

    // Add listeners for live preview
    div.querySelectorAll('input, textarea').forEach(el => el.addEventListener('input', updatePreview));
}

function addIncludedItem(text = '') {
    const container = document.getElementById('includedList');
    const div = document.createElement('div');
    div.className = 'builder-item form-group';
    div.innerHTML = `
        <button class="remove-btn" onclick="this.parentElement.remove(); updatePreview();"><i class="ri-delete-bin-line"></i></button>
        <input type="text" class="included-text" placeholder="Item incluso (ex: Passagens aéreas)" value="${text}">
    `;
    container.appendChild(div);
    div.querySelector('input').addEventListener('input', updatePreview);
}

function addNotIncludedItem(text = '') {
    const container = document.getElementById('notIncludedList');
    const div = document.createElement('div');
    div.className = 'builder-item form-group';
    div.innerHTML = `
        <button class="remove-btn" onclick="this.parentElement.remove(); updatePreview();"><i class="ri-delete-bin-line"></i></button>
        <input type="text" class="not-included-text" placeholder="Item não incluso (ex: Visto)" value="${text}">
    `;
    container.appendChild(div);
    div.querySelector('input').addEventListener('input', updatePreview);
}

function addAccommodation(name = '', img = '', desc = '', stars = 5) {
    const container = document.getElementById('accommodationList');
    const div = document.createElement('div');
    div.className = 'builder-item form-group';
    div.innerHTML = `
        <button class="remove-btn" onclick="this.parentElement.remove(); updatePreview();"><i class="ri-delete-bin-line"></i></button>
        <label>Nome do Hotel</label>
        <input type="text" class="hotel-name" placeholder="Nome do Hotel" value="${name}">
        <label>URL da Imagem</label>
        <input type="text" class="hotel-img" placeholder="https://..." value="${img}">
        <label>Descrição</label>
        <textarea class="hotel-desc" placeholder="Descrição do hotel...">${desc}</textarea>
        <label>Estrelas (1-5)</label>
        <input type="number" class="hotel-stars" min="1" max="5" value="${stars}">
    `;
    container.appendChild(div);
    div.querySelectorAll('input, textarea').forEach(el => el.addEventListener('input', updatePreview));
}

// --- GENERATORS ---

function generateItineraryHTML() {
    const items = document.querySelectorAll('#itineraryList .builder-item');
    if (items.length === 0) return '';

    let html = '<h3>Itinerário detalhado</h3><ol class="itinerary-list">';
    items.forEach((item, index) => {
        const title = item.querySelector('.day-title').value;
        const desc = item.querySelector('.day-desc').value;
        html += `<li class="day"><h4>Dia ${index + 1}: ${title}</h4><p>${desc}</p></li>`;
    });
    html += '</ol>';
    return html;
}

function generateIncludedHTML() {
    const items = document.querySelectorAll('#includedList .included-text');
    if (items.length === 0) return '';

    let html = '<h3>O que está incluso</h3><ul>';
    items.forEach(item => {
        if (item.value) html += `<li><i class="ri-check-line"></i> ${item.value}</li>`;
    });
    html += '</ul>';
    return html;
}

function generateNotIncludedHTML() {
    const items = document.querySelectorAll('#notIncludedList .not-included-text');
    if (items.length === 0) return '';

    let html = '<h3>Não incluso</h3><ul>';
    items.forEach(item => {
        if (item.value) html += `<li><i class="ri-close-line"></i> ${item.value}</li>`;
    });
    html += '</ul>';
    return html;
}

function generateAccommodationHTML() {
    const items = document.querySelectorAll('#accommodationList .builder-item');
    if (items.length === 0) return '';

    let html = '<h3>Hospedagem selecionada</h3>';
    items.forEach(item => {
        const name = item.querySelector('.hotel-name').value;
        const img = item.querySelector('.hotel-img').value;
        const desc = item.querySelector('.hotel-desc').value;
        const stars = parseInt(item.querySelector('.hotel-stars').value) || 5;

        let starsHtml = '';
        for (let i = 0; i < stars; i++) starsHtml += '<i class="ri-star-fill"></i>';

        html += `
        <div class="hotel-card">
            <img src="${img}" alt="${name}">
            <div class="hotel-info">
                <h4>${name}</h4>
                <p>${desc}</p>
                <ul><li>${starsHtml} (${stars} estrelas)</li></ul>
            </div>
        </div>`;
    });
    return html;
}

// --- PREVIEW & SAVE ---

function initPreviewListeners() {
    const fields = ['tripTitle', 'tripPrice', 'tripDuration', 'tripContinent', 'tripCategories', 'tripImage', 'tripShortDesc', 'tripLongDesc'];
    fields.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', updatePreview);
        if (el && el.tagName === 'SELECT') el.addEventListener('change', updatePreview);
    });
}

function updatePreview() {
    const title = document.getElementById('tripTitle').value || 'Título da Viagem';
    const price = document.getElementById('tripPrice').value || 0;
    const duration = document.getElementById('tripDuration').value || '0 dias';
    const continent = document.getElementById('tripContinent').options[document.getElementById('tripContinent').selectedIndex].text;
    const categories = document.getElementById('tripCategories').value || 'Geral';
    const image = document.getElementById('tripImage').value;
    const shortDesc = document.getElementById('tripShortDesc').value || 'Descrição curta...';
    const longDesc = document.getElementById('tripLongDesc').value || '';

    // Update Hero Section
    document.getElementById('previewTitle').textContent = title;
    document.getElementById('previewShortDesc').textContent = shortDesc;
    document.getElementById('previewCategory').textContent = categories;
    document.getElementById('previewDuration').textContent = duration;
    document.getElementById('previewContinent').textContent = continent;
    document.getElementById('previewPrice').textContent = parseFloat(price).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    const imgEl = document.getElementById('previewMainImage');
    if (image) {
        imgEl.src = image;
    } else {
        imgEl.src = '../images/placeholder.jpg';
    }

    // Update Background of Hero (if needed, or just keep it dark/image)
    // The CSS for .trip-hero sets a background image. We might want to override it with the trip image or keep a generic one.
    // For now, let's set the hero background to the trip image as well for a immersive effect, or keep it standard.
    // Let's try to set it to the trip image with a gradient overlay.
    const heroSection = document.getElementById('previewHero');
    if (image) {
        heroSection.style.background = `linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), url('${image}') center/cover no-repeat`;
    }

    // Combine all HTML parts for the long description preview
    const fullHtml = `
        ${longDesc}
        ${generateIncludedHTML()}
        ${generateNotIncludedHTML()}
        ${generateItineraryHTML()}
        ${generateAccommodationHTML()}
    `;

    document.getElementById('previewLongDesc').innerHTML = fullHtml;
}

async function checkEditMode() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (id) {
        try {
            const response = await fetch(`api/get_trip.php?id=${id}`);
            const data = await response.json();

            if (data.error) {
                alert('Erro ao carregar viagem: ' + data.error);
                return;
            }

            // Standard fields
            document.getElementById('tripTitle').value = data.titulo;
            document.getElementById('tripPrice').value = data.preco;
            document.getElementById('tripDuration').value = data.duracao;
            document.getElementById('tripContinent').value = data.continente;
            document.getElementById('tripCategories').value = data.categorias;
            document.getElementById('tripImage').value = data.imagem_url;
            document.getElementById('tripShortDesc').value = data.descricao_curta;
            document.getElementById('tripLongDesc').value = data.descricao_longa;

            // Locations
            if (data.locations) {
                data.locations.forEach(loc => {
                    addLocation(loc.nome, parseFloat(loc.latitude), parseFloat(loc.longitude));
                });
            }

            // Parse HTML fields back to builders
            parseItinerary(data.itinerario_html);
            parseIncluded(data.incluso_html);
            parseNotIncluded(data.nao_incluso_html);
            parseAccommodation(data.hospedagem_html);

            updatePreview();

        } catch (error) {
            console.error('Error fetching trip:', error);
        }
    }
}

// Parsers (Basic DOM parsing)
function parseItinerary(html) {
    if (!html) return;
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const days = doc.querySelectorAll('li.day');
    days.forEach(day => {
        const h4 = day.querySelector('h4').textContent; // "Dia X: Title"
        const title = h4.split(': ')[1] || h4;
        const desc = day.querySelector('p').textContent;
        addItineraryDay(title, desc);
    });
}

function parseIncluded(html) {
    if (!html) return;
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const items = doc.querySelectorAll('li');
    items.forEach(item => {
        addIncludedItem(item.textContent.trim());
    });
}

function parseNotIncluded(html) {
    if (!html) return;
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const items = doc.querySelectorAll('li');
    items.forEach(item => {
        addNotIncludedItem(item.textContent.trim());
    });
}

function parseAccommodation(html) {
    if (!html) return;
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const cards = doc.querySelectorAll('.hotel-card');
    cards.forEach(card => {
        const name = card.querySelector('h4').textContent;
        const img = card.querySelector('img').src;
        const desc = card.querySelector('p').textContent;
        const starsText = card.querySelector('ul li').textContent; // " (5 estrelas)"
        const stars = starsText.match(/\d+/)[0];
        addAccommodation(name, img, desc, stars);
    });
}

async function saveTrip() {
    const title = document.getElementById('tripTitle').value;
    const price = document.getElementById('tripPrice').value;

    if (!title || !price) {
        alert('Título e Preço são obrigatórios!');
        return;
    }

    const tripData = {
        id: new URLSearchParams(window.location.search).get('id'),
        titulo: title,
        preco: price,
        duracao: document.getElementById('tripDuration').value,
        continente: document.getElementById('tripContinent').value,
        categorias: document.getElementById('tripCategories').value,
        imagem_url: document.getElementById('tripImage').value,
        descricao_curta: document.getElementById('tripShortDesc').value,
        descricao_longa: document.getElementById('tripLongDesc').value,
        // Generated HTML fields
        itinerario_html: generateItineraryHTML(),
        incluso_html: generateIncludedHTML(),
        nao_incluso_html: generateNotIncludedHTML(),
        hospedagem_html: generateAccommodationHTML(),
        locations: locations
    };

    try {
        const response = await fetch('api/save_trip.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(tripData)
        });

        const result = await response.json();

        if (result.success) {
            alert('Viagem salva com sucesso!');
            window.location.href = 'trips.php';
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
