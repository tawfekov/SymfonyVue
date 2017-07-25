import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router/'
import Buefy from 'buefy'
/// application specific 
import App from './App'

Vue.config.productionTip = false
Vue.use(Buefy)
Vue.use(VueRouter);

// bootstrap the demo
let demo = new Vue({
  el: '#vueApp',
  router,
  template: '<App/>',
  components: { App }
})