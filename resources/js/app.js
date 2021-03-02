require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('index-index', require('./components/Books/Index.vue').default)

const app = new Vue({
    el : '#app'
});
