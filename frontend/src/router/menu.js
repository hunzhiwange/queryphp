const importRouter = require('./import_' + process.env.NODE_ENV)

export default (routers, data) => {
    //这里之所以要重新遍历一下，是因为，通常我们动态路由的时候，是获取服务端数据，这个 component 属性是一个字符串，或者可能连字段名都是其他的key
    //所以这里要做一些转换
    // https://github.com/sunlandong/dynamicRouter
    generaMenu(routers, data)
}

//
function generaMenu(routers, data) {
    data.forEach(item => {
        let menu = Object.assign({}, item)
        if (menu.component) {
            if (menu.component == 'layout') {
                menu.component = 'layout/layout'
            }
            menu.component = importRouter(menu.component)
        }
        if (/*!item.leaf*/ item.children) {
            menu.children = []
            generaMenu(menu.children, item.children)
        }
        routers.push(menu)
    })
}
