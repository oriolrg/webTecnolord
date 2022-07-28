/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
/**
 * 
 * Components Administrador 
 * 
 * */
/* Components administra clients */
Vue.component('administra-clients-component', require('./components/administrador/usuaris/AdministraClientsComponent.vue').default);
Vue.component('nou-client-component', require('./components/administrador/usuaris/NouClientComponent.vue').default);
/* Components administra Projectes */
Vue.component('administra-projectes-component', require('./components/administrador/projectes/AdministraProjectesComponent.vue').default);
Vue.component('autocomplete-categoria-component', require('./components/administrador/projectes/AutocompleteCategoriaComponent.vue').default);
Vue.component('nou-projecte-component', require('./components/administrador/projectes/NouProjecteComponent.vue').default);
Vue.component('select-clients-component', require('./components/administrador/projectes/SelectClientsComponent.vue').default);
/* Components administra Histories */
Vue.component('administra-histories-component', require('./components/administrador/histories/AdministraHistoriesComponent.vue').default);
Vue.component('nou-historia-component', require('./components/administrador/histories/NouHistoriaComponent.vue').default);
Vue.component('select-projecte-component', require('./components/administrador/histories/SelectProjecteComponent.vue').default);
/* Components administra Bugs */
Vue.component('administra-bugs-component', require('./components/administrador/bugs/AdministraBugsComponent.vue').default);
Vue.component('nou-bug-component', require('./components/administrador/bugs/NouBugComponent.vue').default);
/* Components administra Projectes */
Vue.component('administra-projectes-publicats-component', require('./components/administrador/projectesPublicats/AdministraProjectesPublicatsComponent.vue').default);

/**
 * 
 * Components Clients 
 * 
 * */
/* Components client Projectes */
Vue.component('client-projectes-component', require('./components/client/projectes/AdministraProjectesComponent.vue').default);
Vue.component('client-select-projectes-component', require('./components/client/histories/SelectProjecteComponent.vue').default);
/* Components client Histories */
Vue.component('client-histories-component', require('./components/client/histories/AdministraHistoriesComponent.vue').default);
Vue.component('client-nou-historia-component', require('./components/client/histories/NouHistoriaComponent.vue').default);
/* Components client Bugs */
Vue.component('client-bugs-component', require('./components/client/bugs/AdministraBugsComponent.vue').default);
Vue.component('client-nou-bug-component', require('./components/client/bugs/NouBugComponent.vue').default);


/**
 * 
 * Components Publics
 * 
 * */
Vue.component('meteo-app', require('./components/public/meteo/MeteoApp.vue').default);
Vue.component('escape-component', require('./components/public/escapeRoom/EscapeRoom.vue').default);
/**
 * 
 * Components Meteo
 * 
 * */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import { adminHistoriasUrl } from './config.js';


// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

const app = new Vue({
    el: '#app',
});
