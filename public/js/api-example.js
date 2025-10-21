// Example API call for your Laravel app deployed on Vercel
// Replace 'your-vercel-domain' with your actual Vercel domain

// Get your Vercel domain from the deployment
const API_BASE_URL = 'https://your-vercel-domain.vercel.app/api';

// Example: Get all users
async function getUsers() {
    try {
        const response = await axios.get(`${API_BASE_URL}/users`);
        console.log('Users:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching users:', error);
        throw error;
    }
}

// Example: Get a specific user
async function getUserById(id) {
    try {
        const response = await axios.get(`${API_BASE_URL}/users/${id}`);
        console.log('User:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching user:', error);
        throw error;
    }
}

// Example: Make API call when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Update the API_BASE_URL with your actual Vercel domain
    const currentDomain = window.location.origin;
    API_BASE_URL = `${currentDomain}/api`;
    
    // Example usage
    getUsers().then(data => {
        console.log('All users loaded:', data);
    });
});
