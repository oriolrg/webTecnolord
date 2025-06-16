/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('temperatura-component', require('./components/TemperaturaComponent.vue').default);
Vue.component('pressio-component', require('./components/PressioComponent.vue').default);
Vue.component('vent-component', require('./components/VentComponent.vue').default);
Vue.component('pluja-component', require('./components/PlujaComponent.vue').default);
Vue.component('humitat-component', require('./components/HumitatComponent.vue').default);
Vue.component('uv-component', require('./components/UvComponent.vue').default);
Vue.component('rius-component', require('./components/RiusComponent.vue').default);
Vue.component('llosa-component', require('./components/LlosaComponent.vue').default);
Vue.component('meteo-actual-component', require('./components/MeteoActualComponent.vue').default);
Vue.component('meteo-passat-component', require('./components/MeteoPassatComponent.vue').default);
Vue.component('meteo-app', require('./MeteoApp.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
