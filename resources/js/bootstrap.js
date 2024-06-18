import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.Echo.channel('orders')
    .listen('.order.placed', (e) => {
        console.log('Order placed event received:', e);
    })
    .on('pusher:subscription_succeeded', () => {
        console.log('Successfully subscribed to the orders channel.');
    })
    .on('pusher:subscription_error', (status) => {
        console.error('Subscription error:', status);
    })
    .on('pusher:connection_error', (err) => {
        console.error('Connection error:', err);
    })
    .on('pusher:disconnected', () => {
        console.log('Disconnected from Pusher');
    })
    .on('pusher:member_removed', (member) => {
        console.log('Member removed:', member);
    })
    .on('pusher:member_added', (member) => {
        console.log('Member added:', member);
    });



window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
