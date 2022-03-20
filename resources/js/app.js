require('./bootstrap');
window.Vue = require('vue').default;

import { BootstrapVue } from "bootstrap-vue";
import App from './App.vue';
import Notifications from 'vue-notification'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
Vue.config.productionTip = false;
Vue.use(BootstrapVue);

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Notifications);

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});