document.addEventListener('DOMContentLoaded', () => {
    fetchStats();
});

async function fetchStats() {
    try {
        const response = await fetch('api/stats.php');
        const data = await response.json();

        if (data.error) {
            if (data.error === 'Unauthorized') {
                window.location.href = '../Login/login.php';
            } else {
                console.error('Error fetching stats:', data.error);
            }
            return;
        }

        updateDashboard(data);
        updateUserProfile(data.current_user);
        renderCharts(data);

    } catch (error) {
        console.error('Network error:', error);
    }
}

function updateUserProfile(user) {
    if (user) {
        document.getElementById('admin-name').textContent = user.name;
        // Adjust path if needed, assuming avatar_url is relative to root or absolute
        // If avatar_url starts with 'uploads/', prepend '../'
        let avatarPath = user.avatar;
        if (avatarPath && !avatarPath.startsWith('http') && !avatarPath.startsWith('/')) {
            avatarPath = '../' + avatarPath;
        }
        document.getElementById('admin-avatar').src = avatarPath || '../images/profile/default.jpg';
    }
}

function updateDashboard(data) {
    document.getElementById('total-users').textContent = data.total_users;
    document.getElementById('total-trips').textContent = data.total_trips;
    document.getElementById('total-posts').textContent = data.total_posts;
    document.getElementById('total-topics').textContent = data.total_topics;
}

function renderCharts(data) {
    const ctx = document.getElementById('tripsChart').getContext('2d');

    // Prepare data for chart
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
                    position: 'bottom',
                    labels: {
                        color: '#e0e0e0'
                    }
                }
            }
        }
    });
}
