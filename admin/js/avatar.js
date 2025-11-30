document.addEventListener('DOMContentLoaded', () => {
    fetchCurrentUser();
});

async function fetchCurrentUser() {
    try {
        const response = await fetch('api/stats.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
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
        const nameEl = document.getElementById('admin-name');
        const avatarEl = document.getElementById('admin-avatar');
        
        if (nameEl) nameEl.textContent = user.name;
        
        if (avatarEl) {
            let avatarPath = user.avatar;
            if (avatarPath && !avatarPath.startsWith('http') && !avatarPath.startsWith('/')) {
                avatarPath = '../' + avatarPath;
            }
            avatarEl.src = avatarPath || '../images/profile/default.jpg';
        }
    }
}
