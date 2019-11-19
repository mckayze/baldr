require('./bootstrap');
// require('select2');

window.Vue = require('vue');
// window.VueSelect = require('vue-select');
window.toastr = require('toastr');

Vue.component(
    'media-manager',
    require('./components/mediamanager/manager/MediaManager.vue').default
);

Vue.component(
    'media-modal',
    require('./components/mediamanager/modal/MediaModal.vue').default
);