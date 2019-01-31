import Vue from 'vue'
import Router from 'vue-router'
import iView from 'iview'
import {routers, otherRouter, appRouter} from './router'
import {getToken, isLock} from '../utils/auth'

Vue.use(Router)

let router = new Router({
    // mode: 'history', 后端支持可开
    scrollBehavior: () => ({y: 0}),
    routes: routers,
})

export default router

iView.LoadingBar.config({
    color: '#08fa34',
    //failedColor: '#f0ad4e',
    //height: 5
})

let ignoreRouter = ['404', '403', '500', 'locking', 'login', 'dashboard', 'profile_index', 'message_index']

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start()

    setTimeout(() => utils.title(to.meta.title), 0)

    if (!getToken() && to.name !== 'login') {
        next({
            name: 'login',
        })
    } else if (getToken() && to.name === 'login') {
        next({
            name: 'dashboard',
        })
    }

    // 判断当前是否是锁定状态
    else if (isLock() && to.name !== 'locking') {
        next({
            replace: true,
            name: 'locking',
        })
    } else if (!isLock() && to.name === 'locking') {
        next({
            replace: true,
            name: 'dashboard',
        })
    } else if (!ignoreRouter.includes(to.name) && !utils.permission(to.name + '_menu')) {
        next({
            replace: true,
            name: '403',
        })
    } else {
        next()
    }
})

router.afterEach(to => {
    utils.openNewPage(router.app, to.name, to.params, to.query)
    iView.LoadingBar.finish()
    window.scrollTo(0, 0)
})
