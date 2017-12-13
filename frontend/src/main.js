import Vue from 'vue'
import iView from 'iview';
import 'iview/dist/styles/iview.css';
// 支持拖动的表格，直接修改 iview table 组件
// https://github.com/iview/iview/pull/1241
import draggableTable from '@/components/iview/table'
import App from './app'
import VueI18n from 'vue-i18n'
import router from './router'
import {appRouter} from './router/router'
//import routerMenu from './router/menu'
import store from './store'
import * as filters from './filters' // 全局filter
import _ from 'lodash'
import axios from 'axios'
import moment from 'moment'
import _g from './assets/js/global'
import extend from './assets/js/extend'
import './errorLog' // error log
import './permission' // 权限
import 'assets/css/global.css'

Vue.use(iView)
Vue.use(VueI18n)
Vue.use(extend)
Vue.component('Table', draggableTable)

// let data =  [{
//         path: '/option2222',
//         icon: 'ios-gear',
//         name: 'option222',
//         title: __('设置'),
//         component: 'layout',
//         children: [
//             {
//                 path: 'menu222',
//                 icon: '',
//                 name: 'menu2222_index',
//                 title: __('菜单管理'),
//                 component: 'menu/index'
//                 //component: importRouter('menu/index')
//             },
//             {
//                 path: 'menu23333',
//                 icon: '',
//                 name: '324324222222222222222222222222',
//                 title: __('菜单管理2'),
//                 component: 'menu/index'
//             }
//         ]
//     }];

// if (data){
//   //这里是防止用户手动刷新页面，整个app要重新加载,动态新增的路由，会消失，所以我们重新add一次
//   let routes = []
//   routerMenu(routes,data)
//   router.addRoutes(routes)
//   //window.sessionStorage.removeItem('isLoadNodes')
// }


window.axios = axios

// register global utility filters.
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
})

Vue.config.productionTip = false

// i18n 占位符，自动删除占位符元素
Vue.directive('i18n', {
    inserted: function(el) {
        el.parentNode.removeChild(el)
    }
})

Vue.component('i18n', {template: ' '})

String.prototype.i18n = function() {
    return ''
}

//const bus = new Vue()
//window.bus = bus
window._g = _g
window.store = store
window.BASE_API = BASE_API
window.ENV = ENV
window._ = _
window.router = router
window.moment = moment

window.bus = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
    data: {
        currentPageName: ''
    },
    mounted() {
        this.currentPageName = this.$route.name;
        // 显示打开的页面的列表
        this.$store.commit('setOpenedList');
        //this.$store.commit('initCachepage');
        // 权限菜单过滤相关
        //this.$store.commit('updateMenulist');
        // iview-admin检查更新
        //util.checkUpdate(this);
    },
    created() {
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
