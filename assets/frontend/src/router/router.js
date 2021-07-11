// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading
const importRouter = require('./import_' + process.env.NODE_ENV)
import layout from '../views/layout/layout'
import {sprintf} from 'sprintf-js'

window.__ = window.gettext = function() {
    if ('object' === typeof bus) {
        return bus.__.apply(bus, arguments)
    } else {
        if (arguments.length > 1) {
            return sprintf.apply(null, arguments)
        } else {
            return arguments[0]
        }
    }
}

// 不作为 layout 组件的子页面展示的页面单
export const commonRouter = [
    {
        path: '/login',
        name: 'login',
        meta: {
            title: __('登录'),
        },
        component: importRouter('login/index'),
    },
    {
        path: '/locking',
        name: 'locking',
        meta: {
            title: __('系统已锁定'),
        },
        component: importRouter('layout/lockscreen/components/locking-page'),
    },
    {
        path: '/403',
        name: '403',
        meta: {
            title: __('权限不足'),
        },
        component: importRouter('error-page/403'),
    },
    {
        path: '/404',
        name: '404',
        meta: {
            title: __('页面不存在'),
        },
        component: importRouter('error-page/404'),
    },
    {
        path: '/500',
        name: '500',
        meta: {
            title: __('服务端错误'),
        },
        component: importRouter('error-page/500'),
    },
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
            meta: {
                title: __('首页'),
            },
            name: 'dashboard',
            icon: 'ios-home-outline',
            component: importRouter('dashboard/index'),
        },
        {
            path: 'message',
            meta: {
                title: __('消息中心'),
            },
            name: 'message_index',
            component: importRouter('message/message'),
        },
    ],
}

let appRouterData = [
    {
        path: '/base',
        icon: 'md-settings',
        name: 'base',
        meta: {
            title: __('基础配置'),
        },
        component: layout,
        children: [
            {
                path: 'option',
                icon: '',
                name: 'option_index',
                meta: {
                    title: __('系统配置'),
                    par: ['base'],
                },
                component: importRouter('base/option'),
            },
            {
                path: 'profile',
                icon: '',
                name: 'profile_index',
                meta: {
                    title: __('个人中心'),
                    par: ['base'],
                },
                component: importRouter('base/profile'),
            },
        ],
    },
    {
        path: '/permission',
        icon: 'ios-people',
        name: 'permission',
        meta: {
            title: __('权限管理'),
        },
        component: layout,
        children: [
            {
                path: 'user',
                icon: '',
                name: 'user_index',
                meta: {
                    title: __('用户管理'),
                    par: ['permission'],
                },
                component: importRouter('user/index'),
            },
            {
                path: 'role',
                icon: '',
                name: 'role_index',
                meta: {
                    title: __('角色管理'),
                    par: ['permission'],
                },
                component: importRouter('role/index'),
            },
            {
                path: 'permission',
                icon: '',
                name: 'permission_index',
                meta: {
                    title: __('权限管理'),
                    par: ['permission'],
                },
                component: importRouter('permission/index'),
            },
            {
                path: 'resource',
                icon: '',
                name: 'resource_index',
                meta: {
                    title: __('资源管理'),
                    par: ['permission'],
                },
                component: importRouter('resource/index'),
            },
        ],
    },
    {
        path: '/test',
        icon: 'md-checkmark-circle-outline',
        name: 'test',
        meta: {
            title: __('测试页面'),
        },
        component: layout,
        children: [
            {
                path: 'test',
                icon: '',
                name: 'test_index',
                meta: {
                    title: __('测试页面'),
                    par: ['test'],
                },
                component: importRouter('test/test'),
            },
        ],
    },
    {
        path: '/menu',
        icon: 'md-menu',
        name: 'menu',
        meta: {
            title: __('一级菜单'),
        },
        component: layout,
        children: [
            {
                path: 'sub',
                icon: '',
                name: 'sub_index',
                meta: {
                    title: __('二级菜单'),
                    par: ['menu'],
                },
                component: importRouter('layout/router-view'),
                children: [
                    {
                        path: 'three1',
                        icon: '',
                        name: 'three1_index',
                        meta: {
                            title: __('下级菜单 1'),
                            par: ['menu', 'sub_index'],
                        },
                        component: importRouter('menu/test.1'),
                    },
                    {
                        path: 'three2',
                        icon: '',
                        name: 'three2_index',
                        meta: {
                            title: __('下级菜单 2'),
                            par: ['menu', 'sub_index'],
                        },
                        component: importRouter('menu/test.2'),
                    },
                ],
            },
        ],
    },
]

let dataMenu = localStorage.getItem('menus')
dataMenu = dataMenu ? JSON.parse(dataMenu) : []

if (dataMenu) {
    let routes = []
    //routerMenu(routes,dataMenu)
    //appRouterData = appRouterData.concat(routes)
}

export const appRouter = appRouterData

// 作为 layout 组件的子页面展示并且在左侧菜单显示的路由写在 appRouter 里
//export appRouter appRouter

// 所有上面定义的路由都要写在下面的 routers 里
export const routers = [...commonRouter, otherRouter, ...appRouter]
