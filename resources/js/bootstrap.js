window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


try {
    window.tippy    = require('tippy.js');
    window.Alpine   = require('alpinejs').default;
    window.axios    = require('axios');
    window.Chart = require('chart.js/auto').default;

} catch (e) {}

try{
    if(window.Alpine && window.Alpine.start)
    {
        window.Alpine.start();
    }
} catch (e) {}

if(window.axios)
{
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });


/**
 * Toaster START
 * https://codeseven.github.io/toastr/demo.html
 * https://www.npmjs.com/package/toastr
 */

window.toastr = require('toastr');

window.toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "15000",
    "extendedTimeOut": "15000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

/**
 * Toaster END
 */
