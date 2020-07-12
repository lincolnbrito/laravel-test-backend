import Vue from 'vue'
import VueMask from 'v-mask'
import App from './App.vue'
import './main.css'

Vue.use(VueMask);
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')
