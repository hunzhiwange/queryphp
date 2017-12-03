import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import App from './App'
import router from './router'
import {appRouter} from './router'
import store from './store'
import * as filters from './filters' // 全局filter
import Lockr from 'lockr'
import _ from 'lodash'
import axios from 'axios'
import Cookies from 'js-cookie'
import moment from 'moment'
import VueI18n from 'vue-i18n';
import _g from './assets/js/global'
import extend from './assets/js/extend'
import '@/i18n';
import {gettext} from '@/utils/queryphp'
import './icons' // icon
import './errorLog'// error log
import './permission' // 权限
import './mock'  // 该项目所有请求使用mockjs模拟
import 'assets/css/global.css'
import 'assets/css/base.css'

axios.defaults.baseURL = BASE_API+'/admin/'
axios.defaults.timeout = 1000 * 15
axios.defaults.headers.authKey = Lockr.get('authKey')
axios.defaults.headers['Content-Type'] = 'application/json'

Vue.use(ElementUI)
Vue.use(iView)
Vue.use(VueI18n)
Vue.use(extend)

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
window.BASE_API = BASE_API
window.ENV = ENV
window._ = _

// 语言包
window.__ = window.gettext = gettext

window.Lockr = Lockr
window.router = router
window.Cookies = Cookies
window.moment = moment

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App },
  data: {
      currentPageName: ''
  },
  mounted () {
      this.currentPageName = this.$route.name;
      // 显示打开的页面的列表
      this.$store.commit('setOpenedList');
      //this.$store.commit('initCachepage');
      // 权限菜单过滤相关
      //this.$store.commit('updateMenulist');
      // iview-admin检查更新
      //util.checkUpdate(this);
  },
  created () {
      let tagsList = [];
      appRouter.map((item) => {
          if (item.children.length <= 1) {
              tagsList.push(item.children[0]);
          } else {
              tagsList.push(...item.children);
          }
      });
      this.$store.commit('setTagsList', tagsList);
  }
})
