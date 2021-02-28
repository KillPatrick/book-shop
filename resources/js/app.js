require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('reviews-index', require('./components/Reviews/Index.vue').default)

const app = new Vue({
    el : '#app'
});
