try {
    require('bootstrap');
} catch (e) {}

import $ from 'jquery';
window.$ = window.jQuery = $;

$.ajaxSetup({
    headers:
    { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') }
});
