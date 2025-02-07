import axios from 'axios';

// Get CSRF token from Laravel Blade template
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const apiClient = axios.create({
    baseURL: '/',
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'multipart/form-data',
    },
});

export default apiClient;
