import Cookies from 'js-cookie'
import {otherRouter, appRouter} from '@/router/router'
import global from '@/utils/global'
import Vue from 'vue'

const app = {
    state: {
        cachePage: [],
        lang: 'zh-CN',
        isFullScreen: false,
        openedSubmenuArr: [], // 要展开的菜单数组
        menuTheme: 'light', // 主题
        themeColor: '',
        pageOpenedDashboard: {
            title: __('首页'),
            path: '/dashboard',
            name: 'dashboard'
        },
        pageOpenedList: [],
        currentPageName: '',
        currentPath: [
            {
                title: __('首页'),
                icon: 'ios-home-outline',
                path: '/dashboard',
                name: 'dashboard'
            }
        ], // 面包屑数组
        menuList: [],
        routers: [
            otherRouter, ...appRouter
        ],
        tagsList: [...otherRouter.children],
        messageCount: 0,
        dontCache: ['text-editor', 'artical-publish'] // 在这里定义你不想要缓存的页面的name属性值(参见路由配置router.js)
    },
    mutations: {
        setTagsList(state, list) {
            state.tagsList.push(...list);
        },
        updateMenulist(state) {
            let accessCode = parseInt(Cookies.get('access'));
            let menuList = [];

            if (!appRouter) {
                //return
            }

            appRouter.forEach((item, index) => {
                // if (item.access !== undefined) {
                //     if (Util.showThisRoute(item.access, accessCode)) {
                //         if (item.children.length === 1) {
                //             menuList.push(item);
                //         } else {
                //             let len = menuList.push(item);
                //             let childrenArr = [];
                //             childrenArr = item.children.filter(child => {
                //                 if (child.access !== undefined) {
                //                     if (child.access === accessCode) {
                //                         return child;
                //                     }
                //                 } else {
                //                     return child;
                //                 }
                //             });
                //             menuList[len - 1].children = childrenArr;
                //         }
                //     }
                // } else {
                if (item.children.length === 1) {
                    menuList.push(item);
                } else {
                    let len = menuList.push(item);
                    let childrenArr = [];
                    childrenArr = item.children.filter(child => {
                        if (child.access !== undefined) {
                            if (global.showThisRoute(child.access, accessCode)) {
                                return child;
                            }
                        } else {
                            return child;
                        }
                    });
                    let handledItem = JSON.parse(JSON.stringify(menuList[len - 1]));
                    handledItem.children = childrenArr;
                    menuList.splice(len - 1, 1, handledItem);
                }
                //}
            });
            state.menuList = menuList;
        },
        changeMenuTheme(state, theme) {
            state.menuTheme = theme;
        },
        changeMainTheme(state, mainTheme) {
            state.themeColor = mainTheme;
        },
        addOpenSubmenu(state, name) {
            let hasThisName = false;
            let isEmpty = false;
            if (name.length === 0) {
                isEmpty = true;
            }
            if (state.openedSubmenuArr.indexOf(name) > -1) {
                hasThisName = true;
            }
            if (!hasThisName && !isEmpty) {
                state.openedSubmenuArr.push(name);
            }
        },
        closePage(state, name) {
            state.cachePage.forEach((item, index) => {
                if (item === name) {
                    state.cachePage.splice(index, 1);
                }
            });
        },
        initCachepage(state) {
            if (localStorage.cachePage) {
                state.cachePage = JSON.parse(localStorage.cachePage);
            }
        },
        removeTag(state, name) {
            state.pageOpenedList.map((item, index) => {
                if (item.name === name) {
                    state.pageOpenedList.splice(index, 1);
                }
            });
        },
        pageOpenedList(state, get) {
            let openedPage = state.pageOpenedList[get.index];
            if (get.argu) {
                openedPage.argu = get.argu;
            }
            if (get.query) {
                openedPage.query = get.query;
            }
            state.pageOpenedList.splice(get.index, 1, openedPage);
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList);
        },
        clearAllTags(state, vm) {
            state.pageOpenedList = []
            state.cachePage.length = 0
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
            vm.$router.push({name: 'dashboard'})
        },
        clearOtherTags(state, vm) {
            let currentName = vm.$route.name
            let currentIndex = 0

            state.pageOpenedList.forEach((item, index) => {
                if (item.name === currentName) {
                    currentIndex = index
                    return
                }
            })
            if (currentIndex === 0) {
                state.pageOpenedList.splice(0)
            } else {
                state.pageOpenedList.splice(currentIndex + 1)
                state.pageOpenedList.splice(0, currentIndex - 1)
            }
            let newCachepage = state.cachePage.filter(item => {
                return item === currentName
            })
            state.cachePage = newCachepage
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
        },
        clearCurrentTag(state, vm) {
            let currentName = vm.$route.name
            let currentIndex = 0

            state.pageOpenedList.forEach((item, index) => {
                if (item.name === currentName) {
                    currentIndex = index
                    return
                }
            })

            state.pageOpenedList.splice(currentIndex, 1)
            let newCachepage = state.cachePage.filter(item => {
                return item !== currentName
            })
            state.cachePage = newCachepage
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)

            vm.$router.push({
                name: state.pageOpenedList[currentIndex - 1].name
            })
        },
        clearRightsTag(state, vm) {
            let currentName = vm.$route.name
            let currentIndex = 0
            let find = false
            let rightName = []

            state.pageOpenedList.forEach((item, index) => {
                if (item.name === currentName) {
                    currentIndex = index
                    find = true
                }
                if (find === true) {
                    rightName.push(item.name)
                }
            })

            rightName.shift()
            if (rightName.length == 0) {
                return
            }

            state.pageOpenedList.splice(currentIndex + 1)
            let newCachepage = state.cachePage.filter(item => {
                return !rightName.includes(item)
            })
            state.cachePage = newCachepage
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
        },
        clearLeftsTag(state, vm) {
            let currentName = vm.$route.name
            let currentIndex = 0
            let find = false
            let leftName = []

            state.pageOpenedList.forEach((item, index) => {
                if (item.name === currentName) {
                    currentIndex = index
                    find = true
                }
                if (find === false) {
                    leftName.push(item.name)
                }
            })

            if (leftName.length == 0) {
                return
            }

            state.pageOpenedList.splice(0, currentIndex - 1)
            let newCachepage = state.cachePage.filter(item => {
                return !leftName.includes(item)
            })
            state.cachePage = newCachepage
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
        },

        /**
     * 拖动后排序保存
     *
     * @param  {object} state
     * @param  {array} newTags
     * @return void
     */
        dragTags(state, newTags) {
            state.pageOpenedList = newTags
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
        },

        setOpenedList(state) {
            state.pageOpenedList = localStorage.pageOpenedList
                ? JSON.parse(localStorage.pageOpenedList)
                : []
        },
        setCurrentPath(state, pathArr) {
            state.currentPath = pathArr;
        },
        setCurrentPageName(state, name) {
            state.currentPageName = name;
        },
        setAvator(state, path) {
            localStorage.avatorImgPath = path;
        },
        switchLang(state, lang) {
            state.lang = lang;
            Vue.config.lang = lang;
        },
        clearOpenedSubmenu(state) {
            state.openedSubmenuArr.length = 0;
        },
        setMessageCount(state, count) {
            state.messageCount = count;
        },
        /**
         * 创建一个标签
         *
         * @param  {object} state
         * @param  {object} tagObj
         * @return {void}
         */
        increateTag(state, tagObj) {
            // 刷新和首页被记入标签中直接跳过
            if (['refresh', 'dashboard'].includes(tagObj.name)) {
                return
            }

            if (!global.oneOf(tagObj.name, state.dontCache)) {
                state.cachePage.push(tagObj.name)
                localStorage.cachePage = JSON.stringify(state.cachePage)
            }
            state.pageOpenedList.push(tagObj)
            localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
        }
    },
    actions: {
        showLeftMenu({
            commit
        }, status) {
            commit('showLeftMenu', status)
        },
        showLoading({
            commit
        }, status) {
            commit('showLoading', status)
        },
        setMenus({
            commit
        }, menus) {
            commit('setMenus', menus)
        },
        setRules({
            commit
        }, rules) {
            commit('setRules', rules)
        },
        setUsers({
            commit
        }, users) {
            commit('setUsers', users)
        },
        setUserGroups({
            commit
        }, userGroups) {
            commit('setUserGroups', userGroups)
        },
        setOrganizes({
            commit
        }, organizes) {
            commit('setOrganizes', organizes)
        }
    }
}

export default app
