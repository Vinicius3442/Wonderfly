document.addEventListener('DOMContentLoaded', () => {
    initDashboard();
});

async function initDashboard() {
    loadCurrencyRates();
    loadWeather();
    loadActivityFeed();
    loadTripsChart();
    loadTopDestinations();
    initMap();
}

// 1. Currency Rates (AwesomeAPI)
async function loadCurrencyRates() {
    const container = document.getElementById('currency-widget');
    if (!container) return;

    try {
        const response = await fetch('https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,GBP-BRL');
        const data = await response.json();

        const rates = [
            { code: 'USD', name: 'Dólar', value: data.USDBRL },
            { code: 'EUR', name: 'Euro', value: data.EURBRL },
            { code: 'GBP', name: 'Libra', value: data.GBPBRL }
        ];

        let html = '<div class="currency-grid">';
        rates.forEach(rate => {
            const variationClass = parseFloat(rate.value.pctChange) >= 0 ? 'text-green' : 'text-red';
            const icon = parseFloat(rate.value.pctChange) >= 0 ? 'ri-arrow-up-line' : 'ri-arrow-down-line';

            html += `
                <div class="currency-item">
                    <div class="currency-header">
                        <span class="currency-code">${rate.code}</span>
                        <span class="currency-name">${rate.name}</span>
                    </div>
                    <div class="currency-value">R$ ${parseFloat(rate.value.bid).toFixed(2)}</div>
                    <div class="currency-change ${variationClass}">
                        <i class="${icon}"></i> ${rate.value.pctChange}%
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading currency:', error);
        container.innerHTML = '<p class="error-msg">Erro ao carregar cotações.</p>';
    }
}

// 2. Weather (Open-Meteo)
async function loadWeather() {
    const container = document.getElementById('weather-widget');
    if (!container) return;

    // Coordinates for: Paris, Tokyo, New York, Rio de Janeiro
    const locations = [
        { name: 'Paris', lat: 48.8566, lon: 2.3522 },
        { name: 'Tóquio', lat: 35.6762, lon: 139.6503 },
        { name: 'Nova York', lat: 40.7128, lon: -74.0060 },
        { name: 'Rio de Janeiro', lat: -22.9068, lon: -43.1729 }
    ];

    try {
        let html = '<div class="weather-grid">';

        for (const loc of locations) {
            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${loc.lat}&longitude=${loc.lon}&current_weather=true`);
            const data = await response.json();
            const temp = Math.round(data.current_weather.temperature);
            const code = data.current_weather.weathercode;
            const icon = getWeatherIcon(code);

            html += `
                <div class="weather-item">
                    <div class="weather-city">${loc.name}</div>
                    <div class="weather-temp">
                        <i class="${icon}"></i> ${temp}°C
                    </div>
                </div>
            `;
        }

        html += '</div>';
        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading weather:', error);
        container.innerHTML = '<p class="error-msg">Erro ao carregar clima.</p>';
    }
}

function getWeatherIcon(code) {
    // WMO Weather interpretation codes (http://www.nodc.noaa.gov/archive/arc0021/0002199/1.1/data/0-data/HTML/WMO-CODE/WMO4677.HTM)
    if (code === 0) return 'ri-sun-line';
    if (code >= 1 && code <= 3) return 'ri-cloudy-line';
    if (code >= 45 && code <= 48) return 'ri-foggy-line';
    if (code >= 51 && code <= 67) return 'ri-drizzle-line';
    if (code >= 71 && code <= 77) return 'ri-snowy-line';
    if (code >= 80 && code <= 82) return 'ri-rainy-line';
    if (code >= 95 && code <= 99) return 'ri-thunderstorms-line';
    return 'ri-sun-cloudy-line';
}

// 3. Activity Feed (Internal API)
async function loadActivityFeed() {
    const container = document.getElementById('activity-feed');
    if (!container) return;

    try {
        const response = await fetch('api/dashboard_data.php');
        const data = await response.json();

        if (data.activities.length === 0) {
            container.innerHTML = '<p>Nenhuma atividade recente.</p>';
            return;
        }

        let html = '<ul class="activity-list">';
        data.activities.forEach(activity => {
            html += `
                <li class="activity-item">
                    <div class="activity-icon" style="background-color: ${activity.color}20; color: ${activity.color}">
                        <i class="${activity.icon}"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-msg">${activity.message}</p>
                        <span class="activity-time">${new Date(activity.date).toLocaleString('pt-BR')}</span>
                    </div>
                </li>
            `;
        });
        html += '</ul>';
        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading activity:', error);
        container.innerHTML = '<p class="error-msg">Erro ao carregar atividades.</p>';
    }
}



// ... (Currency and Weather functions remain unchanged) ...

// 3. Activity Feed (Internal API)
// ... (Activity Feed function remains unchanged) ...

// 4. Interactive Map (Leaflet Choropleth)
async function initMap() {
    const mapContainer = document.getElementById('users-map');
    if (!mapContainer) return;

    // Initialize map
    const map = L.map('users-map').setView([20, 0], 2);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // Mock Data: Users per Country
    const userCounts = {
        'Brazil': 150,
        'United States of America': 80,
        'France': 45,
        'Japan': 30,
        'Australia': 20,
        'United Kingdom': 60,
        'India': 90,
        'China': 40,
        'Germany': 55,
        'Italy': 35
    };

    function getColor(d) {
        return d > 100 ? '#800026' :
            d > 50 ? '#BD0026' :
                d > 20 ? '#E31A1C' :
                    d > 10 ? '#FC4E2A' :
                        d > 5 ? '#FD8D3C' :
                            d > 0 ? '#FEB24C' :
                                '#FFEDA0';
    }

    function style(feature) {
        const count = userCounts[feature.properties.name] || 0;
        return {
            fillColor: count > 0 ? getColor(count) : 'transparent',
            weight: 1,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }

    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 2,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.9
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }

        info.update(layer.feature.properties);
    }

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight
        });
    }

    // Custom Info Control
    var info = L.control();

    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };

    // method that we will use to update the control based on feature properties passed
    info.update = function (props) {
        const count = props ? (userCounts[props.name] || 0) : 0;
        this._div.innerHTML = '<h4>Usuários por País</h4>' + (props ?
            '<b>' + props.name + '</b><br />' + count + ' usuários'
            : 'Passe o mouse sobre um país');
    };

    info.addTo(map);

    // Fetch World GeoJSON
    try {
        const response = await fetch('js/countries.geo.json');
        const data = await response.json();

        var geojson = L.geoJson(data, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);

    } catch (error) {
        console.error('Error loading map data:', error);
    }
}

// 5. Trip Distribution Chart (Chart.js)
async function loadTripsChart() {
    const ctx = document.getElementById('tripsChart');
    if (!ctx) return;

    try {
        const response = await fetch('api/dashboard_data.php');
        const data = await response.json();

        if (!data.trips_by_continent) return;

        const labels = data.trips_by_continent.map(item => item.continente);
        const counts = data.trips_by_continent.map(item => item.count);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Viagens por Continente',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#e0e0e0'
                        }
                    },
                    title: {
                        display: false,
                        text: 'Distribuição Global'
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error loading trips chart:', error);
    }
}

async function loadTopDestinations() {
    const container = document.getElementById('top-destinations');
    if (!container) return;

    try {
        const response = await fetch('api/dashboard_data.php');
        const data = await response.json();

        if (!data.top_destinations || data.top_destinations.length === 0) {
            container.innerHTML = '<p>Nenhum destino em alta.</p>';
            return;
        }

        // Calculate max for progress bar
        const maxReviews = Math.max(...data.top_destinations.map(d => d.review_count));

        let html = '<div class="destinations-list">';
        data.top_destinations.forEach(dest => {
            const percent = maxReviews > 0 ? (dest.review_count / maxReviews) * 100 : 0;
            html += `
                <div class="destination-item">
                    <div class="destination-info">
                        <span style="font-weight: 500;">${dest.titulo}</span>
                        <span style="color: var(--text-muted);">${dest.review_count} avaliações</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: ${percent}%"></div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;

    } catch (error) {
        console.error('Error loading top destinations:', error);
        container.innerHTML = '<p class="error-msg">Erro ao carregar destinos.</p>';
    }
}
