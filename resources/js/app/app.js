
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.moment = require('moment');

window.Vue = require('vue');


/**
 * Vue Router
 */

import routes from './routes';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

const router = new VueRouter({
    routes: routes
});

/**
 * Vuex
 */

import Vuex from 'vuex';
import Store from './store';
Vue.use(Vuex);

const store = new Vuex.Store(Store);


/**
 * Components
 */

/*
Nprogress
 */

import 'nprogress/nprogress.css';





/*
Spinner
 */

Vue.component('spinner', require('./components/spinner'));


/*
Plugins
 */

import Pagination from './plugins/pagination';
Vue.use(Pagination);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

const app = require('./app.vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    router: router,
    store,
    render: h => h(app)
}).$mount('#app');
