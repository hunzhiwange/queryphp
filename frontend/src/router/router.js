// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading
const importRouter = require('./import_' + process.env.NODE_ENV)
import '@/i18n'
import layout from '../views/layout/layout'

// 不作为 layout 组件的子页面展示的页面单
export const commonRouter = [
    {
        path: '/login',
        title: __('登录'),
        component: importRouter('login/index')
    }, {
        path: '/locking',
        name: 'locking',
        component: importRouter('layout/lockscreen/components/locking-page')
    }, {
        path: '/403',
        title: '403 ' + __('权限不足'),
        component: importRouter('error-page/403')
    }, {
        path: '/404',
        title: '404 ' + __('页面不存在'),
        component: importRouter('error-page/404')
    }, {
        path: '/500',
        title: '500 ' + __('服务端错误'),
        component: importRouter('error-page/500')
    }
]

// 作为 layout 组件的子页面展示但是不在左侧菜单显示的路由写在 otherRouter 里
export const otherRouter = {
    path: '/',
    component: layout,
    redirect: '/dashboard',
    name: 'otherRouter',
    children: [
        {
            path: 'dashboard',
            title: __('首页'),
            name: 'dashboard',
            icon: 'ios-home-outline',
            component: importRouter('dashboard/index')
        }, {
            title: __('刷新页面'),
            path: 'refresh',
            component: importRouter('layout/refresh'),
            name: 'refresh'
        }, {
            path: 'message',
            title: __('消息中心'),
            name: 'message_index',
            component: importRouter('message/message')
        }
    ]
}

// 作为 layout 组件的子页面展示并且在左侧菜单显示的路由写在 appRouter 里
export const appRouter = [
    {
        path: '/option',
        icon: 'ios-gear',
        name: 'option',
        title: __('设置'),
        component: layout,
        children: [
            {
                path: 'menu',
                icon: '',
                name: 'menu_index',
                title: __('菜单管理'),
                component: importRouter('menu/index')
            },
            {
                path: 'menu2',
                icon: '',
                name: 'menu2_index',
                title: __('菜单管理2'),
                component: importRouter('menu/index')
            }
        ]
    }
]

// 所有上面定义的路由都要写在下面的 routers 里
export const routers = [
    ...commonRouter,
    otherRouter,
    ...appRouter
]
