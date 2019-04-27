var minimatch = require('minimatch')

let util = {}

util.title = function(title) {
    window.document.title = __(title)
}

util.inOf = function(arr, targetArr) {
    let res = true
    arr.map(item => {
        if (targetArr.indexOf(item) < 0) {
            res = false
        }
    })
    return res
}

util.oneOf = function(ele, targetArr) {
    if (targetArr.indexOf(ele) >= 0) {
        return true
    } else {
        return false
    }
}

util.showThisRoute = function(itAccess, currentAccess) {
    if (typeof itAccess === 'object' && Array.isArray(itAccess)) {
        return util.oneOf(currentAccess, itAccess)
    } else {
        return itAccess === currentAccess
    }
}

util.getRouterObjByName = function(routers, name) {
    if (!name || !routers || !routers.length) {
        return null
    }

    let routerObj = null
    for (let item of routers) {
        if (item.name === name) {
            return item
        }
        routerObj = util.getRouterObjByName(item.children, name)
        if (routerObj) {
            return routerObj
        }
    }
    return null
}

util.handleItem = function(vm, item) {
    if (item == undefined) {
        return false
    }

    return {
        meta: {
            title: item.meta && item.meta.title ? item.meta.title : '',
        },
        icon: item.icon ? item.icon : '',
        name: item.name,
        path: item.path,
    }
}

util.setCurrentPath = function(vm, name) {
    let curRouter = []
    let currentPathArr = []
    let isOtherRouter = false

    vm.$store.state.app.routers.forEach(item => {
        if (item.children.length === 1) {
            if (item.children[0].name === name) {
                curRouter = util.handleItem(vm, item)

                if (item.name === 'otherRouter') {
                    isOtherRouter = true
                }
            }
        } else {
            item.children.forEach(child => {
                if (child.name === name) {
                    curRouter = util.handleItem(vm, child)

                    if (item.name === 'otherRouter') {
                        isOtherRouter = true
                    }
                }
            })
        }
    })

    if (name === 'dashboard') {
        currentPathArr = [curRouter]
    } else if (name && isOtherRouter) {
        currentPathArr = [util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')), curRouter]
    } else {
        let currentPathObj = vm.$store.state.app.routers.filter(item => {
            if (item.children.length <= 1) {
                return item.children[0].name === name
            } else {
                let i = 0
                let childArr = item.children
                let len = childArr.length
                while (i < len) {
                    if (childArr[i].name === name) {
                        return true
                    }
                    i++
                }
                return false
            }
        })[0]

        if (currentPathObj === undefined) {
            throw 'Can not find children router'
        } else if (currentPathObj.children.length <= 1) {
            currentPathArr = [util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')), util.handleItem(vm, currentPathObj)]
        } else {
            let childObj = currentPathObj.children.filter(child => {
                return child.name === name
            })[0]

            let parent = util.handleItem(vm, currentPathObj)
            let childFirst = util.handleItem(vm, currentPathObj.children[0])
            parent.name = childFirst.name
            parent.path = childFirst.path

            currentPathArr = [util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')), parent, util.handleItem(vm, childObj)]
        }
    }

    vm.$store.commit('setCurrentPath', currentPathArr)
    return currentPathArr
}

util.openNewPage = function(vm, name, argu, query) {
    if (vm.$store === undefined) {
        return
    }

    let pageOpenedList = vm.$store.state != undefined ? vm.$store.state.app.pageOpenedList : []
    let openedPageLen = pageOpenedList.length
    let i = 0
    let tagHasOpened = false
    while (i < openedPageLen) {
        if (name === pageOpenedList[i].name) {
            // 页面已经打开
            vm.$store.commit('pageOpenedList', {
                index: i,
                argu: argu,
                query: query,
            })
            tagHasOpened = true
            break
        }
        i++
    }
    if (!tagHasOpened) {
        let tag = vm.$store.state.app.tagsList.filter(item => {
            if (item.children) {
                return name === item.children[0].name
            } else {
                return name === item.name
            }
        })

        tag = tag[0]
        if (tag) {
            tag = tag.children ? tag.children[0] : tag
            if (argu) {
                tag.argu = argu
            }
            if (query) {
                tag.query = query
            }
            vm.$store.commit('increateTag', tag)
        }
    }
    vm.$store.commit('setCurrentPageName', name)
}

util.toDefaultPage = function(routers, name, route, next) {
    let len = routers.length
    let i = 0
    let notHandle = true
    while (i < len) {
        if (routers[i].name === name && routers[i].children && routers[i].redirect === undefined) {
            route.replace({name: routers[i].children[0].name})
            notHandle = false
            next()
            break
        }
        i++
    }
    if (notHandle) {
        next()
    }
}

util.fullscreenEvent = function(vm) {
    vm.$store.commit('initCachePage')
    // 权限菜单过滤相关
    vm.$store.commit('updateMenulist')
    // 全屏相关
}

util.j2s = function(obj) {
    return JSON.stringify(obj)
}

util.cloneJson = function(obj) {
    return JSON.parse(JSON.stringify(obj))
}

util.success = function(message, title) {
    bus.$Notice.success({
        title: title ? title : '',
        desc: message ? message : __('操作成功'),
    })
}

util.info = function(message, title) {
    bus.$Notice.info({
        title: title ? title : '',
        desc: message ? message : __('操作成功'),
    })
}

util.warning = function(message, title) {
    bus.$Notice.warning({
        title: title ? title : '',
        desc: message ? message : __('操作失败'),
    })
}

util.error = function(message) {
    bus.$Message.error({content: message ? message : __('操作失败'), duration: 5})
}

util.clearVuex = function(cate) {
    store.dispatch(cate, [])
}

util.getHasRule = function(val) {
    const moduleRule = 'admin'
    let userInfo = JSON.parse(localStorage.getItem('userInfo'))

    if (userInfo.id == 1) {
        return true
    } else {
        let authList = moduleRule + JSON.parse(localStorage.getItem('authList'))
        return _.includes(authList, val)
    }
}

util.parseTime = function(time, cFormat) {
    if (arguments.length === 0) {
        return null
    }
    const format = cFormat || '{y}-{m}-{d} {h}:{i}:{s}'
    let date
    if (typeof time === 'object') {
        date = time
    } else {
        if (('' + time).length === 10) time = parseInt(time) * 1000
        date = new Date(time)
    }
    const formatObj = {
        y: date.getFullYear(),
        m: date.getMonth() + 1,
        d: date.getDate(),
        h: date.getHours(),
        i: date.getMinutes(),
        s: date.getSeconds(),
        a: date.getDay(),
    }
    const time_str = format.replace(/{(y|m|d|h|i|s|a)+}/g, (result, key) => {
        let value = formatObj[key]
        if (key === 'a') return ['一', '二', '三', '四', '五', '六', '日'][value - 1]
        if (result.length > 0 && value < 10) {
            value = '0' + value
        }
        return value || 0
    })
    return time_str
}

util.formatTime = function(time, option) {
    time = +time * 1000
    const d = new Date(time)
    const now = Date.now()

    const diff = (now - d) / 1000

    if (diff < 30) {
        return '刚刚'
    } else if (diff < 3600) {
        // less 1 hour
        return Math.ceil(diff / 60) + '分钟前'
    } else if (diff < 3600 * 24) {
        return Math.ceil(diff / 3600) + '小时前'
    } else if (diff < 3600 * 24 * 2) {
        return '1天前'
    }
    if (option) {
        return parseTime(time, option)
    } else {
        return d.getMonth() + 1 + '月' + d.getDate() + '日' + d.getHours() + '时' + d.getMinutes() + '分'
    }
}

// 格式化时间
util.getQueryObject = function(url) {
    url = url == null ? window.location.href : url
    const search = url.substring(url.lastIndexOf('?') + 1)
    const obj = {}
    const reg = /([^?&=]+)=([^?&=]*)/g
    search.replace(reg, (rs, $1, $2) => {
        const name = decodeURIComponent($1)
        let val = decodeURIComponent($2)
        val = String(val)
        obj[name] = val
        return rs
    })
    return obj
}

/**
 *get getByteLen
 * @param {Sting} val input value
 * @returns {number} output value
 */
util.getByteLen = function(val) {
    let len = 0
    for (let i = 0; i < val.length; i++) {
        if (val[i].match(/[^\x00-\xff]/gi) != null) {
            len += 1
        } else {
            len += 0.5
        }
    }
    return Math.floor(len)
}

util.cleanArray = function(actual) {
    const newArray = []
    for (let i = 0; i < actual.length; i++) {
        if (actual[i]) {
            newArray.push(actual[i])
        }
    }
    return newArray
}

util.param = function(json) {
    if (!json) return ''
    return cleanArray(
        Object.keys(json).map(key => {
            if (json[key] === undefined) return ''
            return encodeURIComponent(key) + '=' + encodeURIComponent(json[key])
        })
    ).join('&')
}

util.param2Obj = function(url) {
    const search = url.split('?')[1]
    if (!search) {
        return {}
    }
    return JSON.parse(
        '{"' +
            decodeURIComponent(search)
                .replace(/"/g, '\\"')
                .replace(/&/g, '","')
                .replace(/=/g, '":"') +
            '"}'
    )
}

util.html2Text = function(val) {
    const div = document.createElement('div')
    div.innerHTML = val
    return div.textContent || div.innerText
}

util.objectMerge = function(target, source) {
    /* Merges two  objects,
     giving the last one precedence */

    if (typeof target !== 'object') {
        target = {}
    }
    if (Array.isArray(source)) {
        return source.slice()
    }
    for (const property in source) {
        if (source.hasOwnProperty(property)) {
            const sourceProperty = source[property]
            if (typeof sourceProperty === 'object') {
                target[property] = objectMerge(target[property], sourceProperty)
                continue
            }
            target[property] = sourceProperty
        }
    }
    return target
}

util.scrollTo = function(element, to, duration) {
    if (duration <= 0) return
    const difference = to - element.scrollTop
    const perTick = (difference / duration) * 10
    setTimeout(() => {
        console.log(new Date())
        element.scrollTop = element.scrollTop + perTick
        if (element.scrollTop === to) return
        scrollTo(element, to, duration - 10)
    }, 10)
}

util.toggleClass = function(element, className) {
    if (!element || !className) {
        return
    }
    let classString = element.className
    const nameIndex = classString.indexOf(className)
    if (nameIndex === -1) {
        classString += '' + className
    } else {
        classString = classString.substr(0, nameIndex) + classString.substr(nameIndex + className.length)
    }
    element.className = classString
}

util.getTime = function(type) {
    if (type === 'start') {
        return new Date().getTime() - 3600 * 1000 * 24 * 90
    } else {
        return new Date(new Date().toDateString())
    }
}

util.debounce = function(func, wait, immediate) {
    let timeout, args, context, timestamp, result

    const later = function() {
        // 据上一次触发时间间隔
        const last = +new Date() - timestamp

        // 上次被包装函数被调用时间间隔 last 小于设定时间间隔 wait
        if (last < wait && last > 0) {
            timeout = setTimeout(later, wait - last)
        } else {
            timeout = null
            // 如果设定为 immediate===true，因为开始边界已经调用过了此处无需调用
            if (!immediate) {
                result = func.apply(context, args)
                if (!timeout) context = args = null
            }
        }
    }

    return function(...args) {
        context = this
        timestamp = +new Date()
        const callNow = immediate && !timeout
        // 如果延时不存在，重新设定延时
        if (!timeout) timeout = setTimeout(later, wait)
        if (callNow) {
            result = func.apply(context, args)
            context = args = null
        }

        return result
    }
}

util.deepClone = function(source) {
    if (!source && typeof source !== 'object') {
        throw new Error('error arguments', 'shallowClone')
    }
    const targetObj = source.constructor === Array ? [] : {}
    for (const keys in source) {
        if (source.hasOwnProperty(keys)) {
            if (source[keys] && typeof source[keys] === 'object') {
                targetObj[keys] = source[keys].constructor === Array ? [] : {}
                targetObj[keys] = deepClone(source[keys])
            } else {
                targetObj[keys] = source[keys]
            }
        }
    }
    return targetObj
}

var timeoutForOnce = null
util.once = function(fn, time) {
    if (timeoutForOnce) {
        clearTimeout(timeoutForOnce)
    }

    timeoutForOnce = setTimeout(fn, time)
}

util.pregQuote = function(data) {
    // 不包含 *，因为要作为通配符匹配规则
    // Js 版本的 preg-quote
    // http://php.net/manual/zh/function.preg-quote.php
    // JS 配合 minimatch 来实现和 PHP 一样的效果，可能有点差异
    // 通过设置正则规则限制一些非常特殊的字符串来达到效果
    // console.log(minimatch("hello?worldyes", util.pregQuote("hello?world*yes"))) // true
    // $regex = preg_quote($regex, '/');
    // $regex = '/^'.str_replace('\*', '(\S*)', $regex).'$/';
    // return $regex;

    let specials = '.+?[^]$(){}=!<>|-:'

    specials.split('').forEach(v => {
        data = data.replace(new RegExp('\\' + v, 'g'), '\\' + v)
    })

    return data
}

util.permission = function(resource, method) {
    let permissionData = {}

    if ('object' === typeof bus) {
        Object.assign(permissionData, bus.$store.state.user.rules)
    } else {
        // 权限设置
        let temp = window.localStorage.getItem('authList')
        Object.assign(permissionData, temp ? JSON.parse(temp) : {static: [], dynamic: []})
    }

    if (!permissionData.static) {
        return false
    }

    // 超级管理员
    if (permissionData.static.includes('*')) {
        return true
    }

    // 所有请求
    if (permissionData.static.includes(resource)) {
        return true
    }

    // 带有请求类型
    if (method && permissionData.static.includes(method + ':' + resource)) {
        return true
    }

    // 动态类型
    let p = ''

    for (let i = 0; i < permissionData.dynamic.length; i++) {
        p = permissionData.dynamic[i]

        // 无请求类型
        if (minimatch(resource, util.pregQuote(p))) {
            return true
        }

        // 带有请求类型
        if (method && minimatch(method + ':' + resource, util.pregQuote(p))) {
            return true
        }
    }

    return false
}

export default util
