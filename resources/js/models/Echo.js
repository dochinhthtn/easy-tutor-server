import LaravelEcho from 'laravel-echo';
// import Pusher from 'pusher-js';

window.Pusher = require('pusher-js');

const Echo = new LaravelEcho({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // client: Pusher
});

console.log(Echo);

export default Echo;
