import Vue from 'vue'
import Router from 'vue-router'
const importRouter = require('./import_' + process.env.NODE_ENV)
// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading

Vue.use(Router)

/* layout */
import layout from '../views/layout/layout'

/**
* icon : the icon show in the sidebar
* hidden : if `hidden:true` will not show in the sidebar
* redirect : if `redirect:noredirect` will no redirct in the levelbar
* noDropdown : if `noDropdown:true` will has no submenu
* meta : { role: ['admin'] }  will control the page role
**/
export const constantRouterMap = [
    { path: '/login', component: importRouter('login/login'), hidden: true },
    { path: '/authredirect', component: importRouter('login/authredirect'), hidden: true },
    { path: '/404', component: importRouter('errorPage/404'), hidden: true },
    { path: '/401', component: importRouter('errorPage/401'), hidden: true },
  {
    path: '/',
    component: layout,
    redirect: '/dashboard',
    name: '首页',
    hidden: true,
    children: [
        { path: 'dashboard', component: importRouter('dashboard/index') },
        { path: 'dashboard2', component: importRouter('dashboard/index') }
    ]
  },
  {
    path: '/introduction',
    component: layout,
    redirect: '/introduction/index',
    icon: 'people',
    noDropdown: true,
    children: [{ path: 'index', component: importRouter('introduction/index'), name: '简述' }]
},  {
      path: '/test2',
      component: layout,
      icon: 'icon',
      noDropdown: true,
      children: [{ path: 'index', component: importRouter('test2/index'), name: 'test2' }]
    },
]

export default new Router({
  // mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})

export const asyncRouterMap = [
  {
    path: '/permission',
    component: layout,
    redirect: '/permission/index',
    name: '权限测试',
    icon: 'lock',
    meta: { role: ['admin'] },
    noDropdown: true,
    children: [{ path: 'index', component: importRouter('permission/index'), name: '权限测试页', meta: { role: ['admin'] }}]
  },

  {
    path: '/icon',
    component: layout,
    icon: 'icon',
    noDropdown: true,
    children: [{ path: 'index', component: importRouter('svg-icons/index'), name: 'icons' }]
  },
  {
    path: '/components',
    component: layout,
    redirect: '/components/index',
    name: '组件',
    icon: 'component',
    children: [
      { path: 'index', component: importRouter('components/index'), name: '介绍 ' },
      { path: 'tinymce', component: importRouter('components/tinymce'), name: '富文本编辑器' },
      { path: 'markdown', component: importRouter('components/markdown'), name: 'Markdown' },
      { path: 'jsoneditor', component: importRouter('components/jsonEditor'), name: 'JSON编辑器' },
      { path: 'dndlist', component: importRouter('components/dndList'), name: '列表拖拽' },
      { path: 'splitpane', component: importRouter('components/splitpane'), name: 'SplitPane' },
      { path: 'avatarupload', component: importRouter('components/avatarUpload'), name: '头像上传' },
      { path: 'dropzone', component: importRouter('components/dropzone'), name: 'Dropzone' },
      { path: 'sticky', component: importRouter('components/sticky'), name: 'Sticky' },
      { path: 'countto', component: importRouter('components/countTo'), name: 'CountTo' },
      { path: 'mixin', component: importRouter('components/mixin'), name: '小组件' },
      { path: 'backtotop', component: importRouter('components/backToTop'), name: '返回顶部' }
    ]
  },
  {
    path: '/charts',
    component: layout,
    redirect: '/charts/index',
    name: '图表',
    icon: 'chart',
    children: [
      { path: 'index', component: importRouter('charts/index'), name: '介绍' },
      { path: 'keyboard', component: importRouter('charts/keyboard'), name: '键盘图表' },
      { path: 'keyboard2', component: importRouter('charts/keyboard2'), name: '键盘图表2' },
      { path: 'line', component: importRouter('charts/line'), name: '折线图' },
      { path: 'mixchart', component: importRouter('charts/mixChart'), name: '混合图表' }
    ]
  },
  {
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
          { path: 'dynamictable', component: importRouter('example/table/dynamictable/index'), name: '动态table' },
          { path: 'dragtable', component: importRouter('example/table/dragTable'), name: '拖拽table' },
          { path: 'inline_edit_table', component: importRouter('example/table/inlineEditTable'), name: 'table内编辑' },
          { path: 'table', component: importRouter('example/table/table'), name: '综合table' }
        ]
      },
      { path: 'form/edit', icon: 'form', component: importRouter('example/form'), name: '编辑Form', meta: { isEdit: true }},
      { path: 'form/create', icon: 'form', component: importRouter('example/form'), name: '创建Form' },
      { path: 'tab/index', icon: 'tab', component: importRouter('example/tab/index'), name: 'Tab' }
    ]
  },
  {
    path: '/error',
    component: layout,
    redirect: 'noredirect',
    name: '错误页面',
    icon: '404',
    children: [
      { path: '401', component: importRouter('errorPage/401'), name: '401' },
      { path: '404', component: importRouter('errorPage/404'), name: '404' }
    ]
  },
  {
    path: '/errlog',
    component: layout,
    redirect: 'noredirect',
    name: 'errlog',
    icon: 'bug',
    noDropdown: true,
    children: [{ path: 'log', component: importRouter('errlog/index'), name: '错误日志' }]
  },
  {
    path: '/excel',
    component: layout,
    redirect: '/excel/download',
    name: 'excel',
    icon: 'excel',
    children: [
      { path: 'download', component: importRouter('excel/index'), name: 'export excel' },
      { path: 'download2', component: importRouter('excel/selectExcel'), name: 'export selected' },
      { path: 'upload', component: importRouter('excel/uploadExcel'), name: 'upload excel' }
    ]
  },
  {
    path: '/zip',
    component: layout,
    redirect: '/zip/download',
    name: 'zip',
    icon: 'zip',
    children: [
      { path: 'download', component: importRouter('zip/index'), name: 'export zip' }
    ]
  },
  {
    path: '/theme',
    component: layout,
    redirect: 'noredirect',
    name: 'theme',
    icon: 'theme',
    noDropdown: true,
    children: [{ path: 'index', component: importRouter('theme/index'), name: '换肤' }]
  },
  {
    path: '/clipboard',
    component: layout,
    redirect: 'noredirect',
    icon: 'clipboard',
    noDropdown: true,
    children: [{ path: 'index', component: importRouter('clipboard/index'), name: 'clipboard' }]
  },

  { path: '*', redirect: '/404', hidden: true }
]
