import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY,

    wsHost: import.meta.env.VITE_REVERB_HOST || 'localhost',

    wsPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),

    wssPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),

    forceTLS: false,

    enabledTransports: ['ws', 'wss'],
});

console.log('Echo initialized');
console.log('Reverb host:', import.meta.env.VITE_REVERB_HOST);
console.log('Reverb port:', import.meta.env.VITE_REVERB_PORT);
console.log('Reverb key:', import.meta.env.VITE_REVERB_APP_KEY);