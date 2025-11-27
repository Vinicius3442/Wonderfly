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


