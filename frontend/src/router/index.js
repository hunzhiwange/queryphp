import Vue from 'vue'
import Router from 'vue-router'
import iView from 'iview'
import {routers, otherRouter, appRouter} from './router'
import {getToken, isLock} from '../utils/auth'

Vue.use(Router)

let router = new Router({
    // mode: 'history', 后端支持可开
    scrollBehavior: () => ({y: 0}),
    routes: routers
});

export default router

iView.LoadingBar.config({
    color: '#08fa34',
    //failedColor: '#f0ad4e',
    //height: 5
});

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start()
    utils.title(to.meta.title)

    if(!getToken() && to.name !== 'login') {
        next({
            name: 'login'
        })
    }

    else if(getToken() && to.name === 'login') {
        next({
            name: 'dashboard'
        })
    }

    // 判断当前是否是锁定状态
    else if (isLock() && to.name !== 'locking') {
        next({
            replace: true,
            name: 'locking'
        })
    }else if(!isLock() && to.name === 'locking'){
        next({
            replace: true,
            name: 'dashboard'
        })
    }else{
       next()
    }
})

//router.beforeEach((to, from, next) => {
//iView.LoadingBar.start()
//     Util.title(to.meta.title);
//     if (Cookies.get('locking') === '1' && to.name !== 'locking') {   判断当前是否是锁定状态
//         next({
//             replace: true,
//             name: 'locking'
//         });
//     } else if (Cookies.get('locking') === '0' && to.name === 'locking') {
//         next(false);
//     } else {
//         if (!Cookies.get('user') && to.name !== 'login') {   判断是否已经登录且前往的页面不是登录页
//             next({
//                 name: 'login'
//             });
//         } else if (Cookies.get('user') && to.name === 'login') {   判断是否已经登录且前往的是登录页
//             Util.title();
//             next({
//                 name: 'dashboard'
//             });
//         } else {
//             const curRouterObj = Util.getRouterObjByName([otherRouter, ...appRouter], to.name);
//             if (curRouterObj && curRouterObj.access !== undefined) {   需要判断权限的路由
//                 if (curRouterObj.access === parseInt(Cookies.get('access'))) {
//                     Util.toDefaultPage([otherRouter, ...appRouter], to.name, router, next);   如果在地址栏输入的是一级菜单则默认打开其第一个二级菜单的页面
//                 } else {
//                     next({
//                         replace: true,
//                         name: 'error-403'
//                     });
//                 }
//             } else {  没有配置权限的路由, 直接通过
//                 Util.toDefaultPage([...routers], to.name, router, next);
//             }
//         }
//     }
//})

router.afterEach((to) => {
    utils.openNewPage(router.app, to.name, to.params, to.query)
    iView.LoadingBar.finish()
    window.scrollTo(0, 0)
})
