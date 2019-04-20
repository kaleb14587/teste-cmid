import "./bootstrap";
import Vue from "vue";
import Home from "./views/Home";
import App from "./App";
window.vue = Vue;
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
Vue.component('home', require('./views/Home.vue').default);
import ListItem from './components/ListFiles';
Vue.component('listItem',ListItem.default);
const app = new Vue({
    el: '#app',
    render: h => h(App)
});
export default app;
