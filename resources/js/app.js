require('./bootstrap');
require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css');

import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import router from './router'
import VModal from 'vue-js-modal'

// Set Vue globally
window.Vue = Vue;

// Set Vue router
Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VModal);

axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
axios.interceptors.request.use( (config) => {
    if (config.params === undefined ){
        app.$root._data.is_loading = true;
    }else if(config.params.loading === undefined){
        app.$root._data.is_loading = true;
    }
    return config;
}, function (error) {
    app.$root._data.is_loading = true;
    return Promise.reject(error);
});
axios.interceptors.response.use(function (response) {
    app.$root._data.is_loading = false;
    return response;
}, function (error) {
    app.$root._data.is_loading = false;
    return Promise.reject(error);
});


// Load Index
Vue.component('index', Index);
const app = new Vue({
  el: '#app',
  router,
  data: function () {
      return {
          is_loading: false,
      }
  }
});
