import semver from 'semver';
import packjson from '../../package.json';

let util = {};
util.title = function(title) {
    title = title || 'QueryPHP-Vue';
    window.document.title = title;
};

util.inOf = function(arr, targetArr) {
    let res = true;
    arr.map(item => {
        if (targetArr.indexOf(item) < 0) {
            res = false;
        }
    });
    return res;
};

util.oneOf = function(ele, targetArr) {
    if (targetArr.indexOf(ele) >= 0) {
        return true;
    } else {
        return false;
    }
};

util.showThisRoute = function(itAccess, currentAccess) {
    if (typeof itAccess === 'object' && Array.isArray(itAccess)) {
        return util.oneOf(currentAccess, itAccess);
    } else {
        return itAccess === currentAccess;
    }
};

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
            title: item.meta && item.meta.title
                ? item.meta.title
                : ''
        },
        icon: typeof item.icon === 'undefined'
            ? ''
            : item.icon,
        name: item.name,
        path: item.path
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
    } else if (name && (name.indexOf('_index') >= 0 || isOtherRouter)) {
        currentPathArr = [
            util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')),
            curRouter
        ]
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

        if(currentPathObj === undefined){
            throw "Can not find children router"
        }else if (currentPathObj.children.length <= 1) {
            currentPathArr = [
                util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')),
                util.handleItem(vm, currentPathObj)
            ]
        } else {
            let childObj = currentPathObj.children.filter((child) => {
                return child.name === name;
            })[0]

            let parent = util.handleItem(vm, currentPathObj)
            let childFirst = util.handleItem(vm, currentPathObj.children[0])
            parent.name = childFirst.name
            parent.path = childFirst.path

            currentPathArr = [
                util.handleItem(vm, util.getRouterObjByName(vm.$store.state.app.routers, 'dashboard')),
                parent,
                util.handleItem(vm, childObj)
            ]
        }
    }

    vm.$store.commit('setCurrentPath', currentPathArr)
    return currentPathArr
};

util.openNewPage = function(vm, name, argu, query) {
    if(vm.$store === undefined){
        return
    }

    let pageOpenedList = vm.$store.state != undefined ? vm.$store.state.app.pageOpenedList : [];
    let openedPageLen = pageOpenedList.length;
    let i = 0;
    let tagHasOpened = false;
    while (i < openedPageLen) {
        if (name === pageOpenedList[i].name) { // 页面已经打开
            vm.$store.commit('pageOpenedList', {
                index: i,
                argu: argu,
                query: query
            });
            tagHasOpened = true;
            break;
        }
        i++;
    }
    if (!tagHasOpened) {
        let tag = vm.$store.state.app.tagsList.filter((item) => {
            if (item.children) {
                return name === item.children[0].name;
            } else {
                return name === item.name;
            }
        });

        tag = tag[0];
        if (tag) {
            tag = tag.children
                ? tag.children[0]
                : tag;
            if (argu) {
                tag.argu = argu;
            }
            if (query) {
                tag.query = query;
            }
            vm.$store.commit('increateTag', tag);
        }
    }
    vm.$store.commit('setCurrentPageName', name);
};

util.toDefaultPage = function(routers, name, route, next) {
    let len = routers.length;
    let i = 0;
    let notHandle = true;
    while (i < len) {
        if (routers[i].name === name && routers[i].children && routers[i].redirect === undefined) {
            route.replace({name: routers[i].children[0].name});
            notHandle = false;
            next();
            break;
        }
        i++;
    }
    if (notHandle) {
        next();
    }
};

util.fullscreenEvent = function(vm) {
    vm.$store.commit('initCachepage');
    // 权限菜单过滤相关
    vm.$store.commit('updateMenulist');
    // 全屏相关
};

export default util;
