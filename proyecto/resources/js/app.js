/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from 'vuetify';
Vue.use(Vuetify);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('listar-elementos', require('./components/listar-elementos.vue').default);
Vue.component('crear-lista', require('./components/crear-lista.vue').default);
Vue.component('listar-listas', require('./components/listar-listas.vue').default);
Vue.component('crear-tarea', require('./components/crear-tarea.vue').default);
Vue.component('compartir-elemento', require('./components/compartir-elemento.vue').default);
Vue.component('componente-probas', require('./components/componente-probas.vue').default);
Vue.component('borrar-componente', require('./components/borrar-componente.vue').default);
Vue.component('listar-tareas', require('./components/listar-tareas.vue').default);
Vue.component('completar-tarea', require('./components/completar-tarea.vue').default);
Vue.component('eliminar-tarea', require('./components/eliminar-tarea.vue').default);
Vue.component('editar-elemento', require('./components/editar-elemento.vue').default);
Vue.component('listas-proyectos', require('./components/listas-proyectos.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
