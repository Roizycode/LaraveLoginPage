import './bootstrap';

// Import axios for API calls
import axios from 'axios';

// Make axios available globally
window.axios = axios;

// Example API functions
window.getUsers = async function() {
    try {
        const response = await axios.get('/api/users');
        console.log('Users:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching users:', error);
        throw error;
    }
};

window.getUserById = async function(id) {
    try {
        const response = await axios.get(`/api/users/${id}`);
        console.log('User:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching user:', error);
        throw error;
    }
};
