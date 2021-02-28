require('./bootstrap');

import Vue from 'vue'

Vue.component('reviews-index', require('./components/Reviews/Index.vue').default)

const app = new Vue({
    el : '#app'
});

