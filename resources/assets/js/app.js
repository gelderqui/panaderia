
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('clase', require('./components/Clase.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('sucursal', require('./components/Sucursal.vue'));
Vue.component('areacompleto', require('./components/Area.vue'));
Vue.component('produccion', require('./components/Produccion.vue'));
const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
