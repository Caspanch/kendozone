window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// window.$ = window.jQuery = require('jquery');
//  require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
if (!window.Vue) {
    window.Vue = require('vue');
}
window.axios = require('axios');


window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};


window.events = new Vue();
Vue.component('flash', require('./vue/components/Flash.vue'));

window.flash = function (message, level = 'success', action = null) {
    window.events.$emit('flash', { message, level, action });
};

windows.deleteItem = function(url){
    const vm = this;
    this.isRequesting = true;
    axios.post(this.url_delete, function () {
    })
        .then(function (response) {
            if (response.data !== null && response.data.status === 'success') {
                vm.isRequesting = false;
                vm.isVisible = false;
                flash('Item Deleted!');
                return;
            }
            vm.isVisible = true;
            vm.isRequesting = false;
            return flash('Error in deleting Item')

        })
        .catch(function (response) {
            vm.isVisible = true;
            vm.isRequesting = false;
            return flash('Error in deleting Item')
        });
};
windows.restoreItem = function(url){

};