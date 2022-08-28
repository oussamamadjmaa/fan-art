import $ from 'jquery';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.$ = window.jQuery = $;

$.ajaxSetup({
    headers:
    { 'X-CSRF-TOKEN': GLOBAL["CSRF_TOKEN"] }
});

 /**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: GLOBAL["PUSHER_APP_KEY"],
//     cluster: GLOBAL["PUSHER_APP_CLUSTER"],
//     forceTLS: true
// });

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: GLOBAL.PUSHER_APP_KEY,
    cluster: GLOBAL.PUSHER_APP_CLUSTER,
    forceTLS: true
});


if (GLOBAL['userId']) {
    window.Echo.private(`notifications.${GLOBAL.userId}`)
    .listen('notification.new', (e) => {
        window.console.log('yazzzzzzzz')
        window.console.log(e.notification);
    });
}
Pusher.log = function(message) {
    window.console.log(message)
};
