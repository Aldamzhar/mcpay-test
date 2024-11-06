import axios from 'axios';
window.axios = axios;
axios.defaults.baseURL = 'https://ea5d-2-76-44-181.ngrok-free.app';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
