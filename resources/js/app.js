/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'bootstrap';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
import toastr from 'toastr';
window.toastr = toastr;


window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('page-product', require('./components/PageProduct.vue').default);
Vue.component('category-list', require('./components/Category.vue').default);
Vue.component('brand-list', require('./components/Brand.vue').default);
Vue.component('color-list', require('./components/Color.vue').default);
Vue.component('product-list', require('./components/Product.vue').default);
Vue.component('product-detail', require('./components/ProductDetail.vue').default);
Vue.component('user-card', require('./components/Card.vue').default);


const app = new Vue({
    el: '#app',
});
