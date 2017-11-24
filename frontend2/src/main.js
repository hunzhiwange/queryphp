import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App'
import router from './router'
import store from './store'
import * as filters from './filters' // 全局filter
import Lockr from 'lockr'
import _ from 'lodash'
import axios from 'axios'
import Cookies from 'js-cookie'
import moment from 'moment'
import _g from './assets/js/global'
import './icons' // icon
import './errorLog'// error log
import './permission' // 权限
import './mock'  // 该项目所有请求使用mockjs模拟
import 'assets/css/global.css'
import 'assets/css/base.css'

axios.defaults.baseURL = HOST
axios.defaults.timeout = 1000 * 15
axios.defaults.headers.authKey = Lockr.get('authKey')
axios.defaults.headers['Content-Type'] = 'application/json'

Vue.use(ElementUI)

window.axios = axios

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

Vue.config.productionTip = false

const bus = new Vue()
window.bus = bus
window._g = _g
window.store = store
window.HOST = HOST
window._ = _
window.Lockr = Lockr
window.router = router
window.Cookies = Cookies
window.moment = moment

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
