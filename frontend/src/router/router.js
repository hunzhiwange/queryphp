// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading
const importRouter = require('./import_' + process.env.NODE_ENV)

import layout from '../views/layout/layout'

// 不作为 layout 组件的子页面展示的页面单
export const commonRouter = [
    {
        path: '/login',
        title: '登录',
        component: importRouter('login/login'),
        hidden: true
    }, {
        path: '/locking',
        name: 'locking',
        component: importRouter('layout/lockscreen/components/locking-page')
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
            title: '首页',
            name: 'dashboard',
            icon: 'ios-home-outline',
            component: importRouter('dashboard/index')
        },{
            title: '刷新页面',
            path: 'refresh',
            component: importRouter('layout/refresh'),
            name: 'refresh'
        }, {
            path: 'message',
            title: '消息中心',
            name: 'message_index',
            component: importRouter('message/message')
        }
    ]
}

// 作为 layout 组件的子页面展示并且在左侧菜单显示的路由写在 appRouter 里
export const appRouter = [
    {
        path: '/access',
        icon: 'key',
        name: 'access',
        title: '权限管理1',
        component: layout,
        children: [
            {
                path: 'index',
                title: '权限管理1',
                name: 'access_index',
                component: importRouter('test2/index')
            }
        ]
    }, {
        path: '/error-page',
        icon: 'android-sad',
        title: '错误页面2',
        name: 'errorpage',
        component: layout,
        children: [
            {
                icon: 'minus-circled',
                path: 'index',
                title: '错误页面2',
                name: 'errorpage_index',
                component: importRouter('error-page/error-page')
            }
        ]
    }, {
        path: '/option',
        icon: 'social-buffer',
        name: 'option',
        title: '设置',
        component: layout,
        children: [
            {
                path: 'menu',
                icon: 'compose',
                name: 'menu_index',
                title: '菜单管理',
                component: importRouter('menu/index')
            }, {
                path: 'md-editor',
                icon: 'pound',
                name: 'md-editor',
                title: 'Markdown编辑器',
                component: importRouter('error-page/error-page')
            }
        ]
    }, {
        path: '/component2',
        icon: 'social-buffer2',
        name: 'component22',
        title: '组件',
        component: layout,
        children: [
            {
                path: 'text-editor2',
                icon: 'compose',
                name: 'text-editor2',
                title: '富文本编辑器2',
                component: importRouter('error-page/error-page')
            }, {
                path: 'md-editor2',
                icon: 'pound',
                name: 'md-editor33',
                title: 'Markdown编辑器2',
                component: importRouter('error-page/error-page')
            }
        ]
    }, {
        path: '/component3333',
        icon: 'social-buffer',
        name: 'component33',
        title: '组件',
        component: layout,
        children: [
            {
                path: 'text-editor4444',
                icon: 'compose3',
                name: 'text-editor33',
                title: '富文本编辑器',
                component: importRouter('error-page/error-page')
            }, {
                path: 'md-editor233',
                icon: 'pound',
                name: 'md-editor33ewrwer',
                title: 'Markdown编辑器',
                component: importRouter('error-page/error-page')
            }
        ]
    }, {
        path: '/xxxx2342',
        icon: 'social-buffer',
        name: 'component32234243',
        title: '组件',
        component: layout,
        children: [
            {
                path: 'tex33t-editor4444',
                icon: 'compose3',
                name: 'text-33editor33',
                title: '富文本编辑器',
                component: importRouter('error-page/error-page')
            }, {
                path: 'md-3443editor233',
                icon: 'pound',
                name: 'md-e33ditor33ewrwer',
                title: 'Markdown编辑器',
                component: importRouter('error-page/error-page')
            }
        ]
    }, {
        path: '/2334234',
        icon: 'social-buffer',
        name: 'compone333333nt33',
        title: '组件',
        component: layout,
        children: [
            {
                path: 'tex22t-editor4444',
                icon: 'compose3',
                name: 'text33-editor33',
                title: '富文本编辑器',
                component: importRouter('error-page/error-page')
            }, {
                path: 'md-ed3itor233',
                icon: 'pound',
                name: 'md-e333ditor33ewrwer',
                title: 'Markdown编辑器',
                component: importRouter('error-page/error-page')
            }
        ]
    }
]

// 所有上面定义的路由都要写在下面的 routers 里
export const routers = [
    ...commonRouter, otherRouter, ...appRouter
]
