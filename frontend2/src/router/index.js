import Vue from 'vue'
import Router from 'vue-router'
const importRouter = require('./import_' + process.env.NODE_ENV)
// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading
import global from '../utils/global'
import iView from 'iview'

Vue.use(Router)

/* layout */
import layout from '../views/layout/layout'

// 不作为Main组件的子页面展示的页面单独写，如下
export const constantRouterMap = [
    {
        path: '/login',
        component: importRouter('login/login'),
        hidden: true
    }, {
        path: '/authredirect',
        component: importRouter('login/authredirect'),
        hidden: true
    }, {
        path: '/404',
        component: importRouter('errorPage/404'),
        hidden: true
    }, {
        path: '/401',
        component: importRouter('errorPage/401'),
        hidden: true
    }, {
        path: '/locking',
        name: 'locking',
        component: importRouter('layout/lockscreen/components/locking-page')
    }
]

// 作为Main组件的子页面展示但是不在左侧菜单显示的路由写在otherRouter里
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

// 作为Main组件的子页面展示并且在左侧菜单显示的路由写在appRouter里
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
        path: '/component',
        icon: 'social-buffer',
        name: 'component',
        title: '组件',
        component: layout,
        children: [
            {
                path: 'text-editor',
                icon: 'compose',
                name: 'text-editor',
                title: '富文本编辑器3',
                component: importRouter('error-page/error-page')
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

let router = new Router({
    // mode: 'history', 后端支持可开
    scrollBehavior: () => ({y: 0}),
    routes: [
        ...constantRouterMap,
        otherRouter,
        ...appRouter
    ]
})

export default router

iView.LoadingBar.config({
    color: '#08fa34',
    //failedColor: '#f0ad4e',
    //height: 5
});

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start()
    next()
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
    global.openNewPage(router.app, to.name, to.params, to.query)
    iView.LoadingBar.finish()
    window.scrollTo(0, 0)
})

export const asyncRouterMap = [
    {
        path: '/permission',
        component: layout,
        redirect: '/permission/index',
        name: '权限测试',
        icon: 'lock',
        meta: {
            role: ['admin']
        },
        noDropdown: true,
        children: [
            {
                path: 'index',
                component: importRouter('permission/index'),
                name: '权限测试页',
                meta: {
                    role: ['admin']
                }
            }
        ]
    }, {
        path: '/icon',
        component: layout,
        icon: 'icon',
        noDropdown: true,
        children: [
            {
                path: 'index',
                component: importRouter('svg-icons/index'),
                name: 'icons'
            }
        ]
    }, {
        path: '/components',
        component: layout,
        redirect: '/components/index',
        name: '组件',
        icon: 'component',
        children: [
            {
                path: 'index',
                component: importRouter('components/index'),
                name: '介绍 '
            }, {
                path: 'tinymce',
                component: importRouter('components/tinymce'),
                name: '富文本编辑器'
            }, {
                path: 'markdown',
                component: importRouter('components/markdown'),
                name: 'Markdown'
            }, {
                path: 'jsoneditor',
                component: importRouter('components/jsonEditor'),
                name: 'JSON编辑器'
            }, {
                path: 'dndlist',
                component: importRouter('components/dndList'),
                name: '列表拖拽'
            }, {
                path: 'splitpane',
                component: importRouter('components/splitpane'),
                name: 'SplitPane'
            }, {
                path: 'avatarupload',
                component: importRouter('components/avatarUpload'),
                name: '头像上传'
            }, {
                path: 'dropzone',
                component: importRouter('components/dropzone'),
                name: 'Dropzone'
            }, {
                path: 'sticky',
                component: importRouter('components/sticky'),
                name: 'Sticky'
            }, {
                path: 'countto',
                component: importRouter('components/countTo'),
                name: 'CountTo'
            }, {
                path: 'mixin',
                component: importRouter('components/mixin'),
                name: '小组件'
            }, {
                path: 'backtotop',
                component: importRouter('components/backToTop'),
                name: '返回顶部'
            }
        ]
    }, {
        path: '/charts',
        component: layout,
        redirect: '/charts/index',
        name: '图表',
        icon: 'chart',
        children: [
            {
                path: 'index',
                component: importRouter('charts/index'),
                name: '介绍'
            }, {
                path: 'keyboard',
                component: importRouter('charts/keyboard'),
                name: '键盘图表'
            }, {
                path: 'keyboard2',
                component: importRouter('charts/keyboard2'),
                name: '键盘图表2'
            }, {
                path: 'line',
                component: importRouter('charts/line'),
                name: '折线图'
            }, {
                path: 'mixchart',
                component: importRouter('charts/mixChart'),
                name: '混合图表'
            }
        ]
    }, {
        path: '/example',
        component: layout,
        redirect: 'noredirect',
        name: '综合实例',
        icon: 'example',
        children: [
            {
                path: '/example/table',
                component: importRouter('example/table/index'),
                redirect: '/example/table/table',
                name: 'Table',
                icon: 'table',
                children: [
                    {
                        path: 'dynamictable',
                        component: importRouter('example/table/dynamictable/index'),
                        name: '动态table'
                    }, {
                        path: 'dragtable',
                        component: importRouter('example/table/dragTable'),
                        name: '拖拽table'
                    }, {
                        path: 'inline_edit_table',
                        component: importRouter('example/table/inlineEditTable'),
                        name: 'table内编辑'
                    }, {
                        path: 'table',
                        component: importRouter('example/table/table'),
                        name: '综合table'
                    }
                ]
            }, {
                path: 'form/edit',
                icon: 'form',
                component: importRouter('example/form'),
                name: '编辑Form',
                meta: {
                    isEdit: true
                }
            }, {
                path: 'form/create',
                icon: 'form',
                component: importRouter('example/form'),
                name: '创建Form'
            }, {
                path: 'tab/index',
                icon: 'tab',
                component: importRouter('example/tab/index'),
                name: 'Tab'
            }
        ]
    }, {
        path: '/error',
        component: layout,
        redirect: 'noredirect',
        name: '错误页面',
        icon: '404',
        children: [
            {
                path: '401',
                component: importRouter('errorPage/401'),
                name: '401'
            }, {
                path: '404',
                component: importRouter('errorPage/404'),
                name: '404'
            }
        ]
    }, {
        path: '/errlog',
        component: layout,
        redirect: 'noredirect',
        name: 'errlog',
        icon: 'bug',
        noDropdown: true,
        children: [
            {
                path: 'log',
                component: importRouter('errlog/index'),
                name: '错误日志'
            }
        ]
    }, {
        path: '/excel',
        component: layout,
        redirect: '/excel/download',
        name: 'excel',
        icon: 'excel',
        children: [
            {
                path: 'download',
                component: importRouter('excel/index'),
                name: 'export excel'
            }, {
                path: 'download2',
                component: importRouter('excel/selectExcel'),
                name: 'export selected'
            }, {
                path: 'upload',
                component: importRouter('excel/uploadExcel'),
                name: 'upload excel'
            }
        ]
    }, {
        path: '/zip',
        component: layout,
        redirect: '/zip/download',
        name: 'zip',
        icon: 'zip',
        children: [
            {
                path: 'download',
                component: importRouter('zip/index'),
                name: 'export zip'
            }
        ]
    }, {
        path: '/theme',
        component: layout,
        redirect: 'noredirect',
        name: 'theme',
        icon: 'theme',
        noDropdown: true,
        children: [
            {
                path: 'index',
                component: importRouter('theme/index'),
                name: '换肤'
            }
        ]
    }, {
        path: '/clipboard',
        component: layout,
        redirect: 'noredirect',
        icon: 'clipboard',
        noDropdown: true,
        children: [
            {
                path: 'index',
                component: importRouter('clipboard/index'),
                name: 'clipboard'
            }
        ]
    }, {
        path: '*',
        redirect: '/404',
        hidden: true
    }
]
