require('./bootstrap');
import Vue from 'vue/dist/vue'
window.Vue = Vue;
// window.Vue = require('vue');

import axios from "axios";

import Vuex from 'vuex'
Vue.use(Vuex)

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import storeData from "./store/app-store"
const store = new Vuex.Store(
    storeData
)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import {
    routes
} from './routes/app-routes';

const router = new VueRouter({
    mode: 'history',
    routes,
});


import SideMenu from './components/SideMenu/SideMenu.vue'

const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        SideMenu
    }
});


var treeviewMenu = $('.app-menu');
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
	$("[data-toggle='tooltip']").tooltip();