import Cookies from 'js-cookie'
import {otherRouter,appRouter} from '@/router'
import global from '@/utils/global';

const app = {
  state: {
      showLeftMenu: true,
      globalLoading: true,
      menus: [],
      rules: [],
      users: {},
      userGroups: [],
      organizes: [],
      visitedViews: [],

      cachePage: [],
      lang: '',
      isFullScreen: false,
      openedSubmenuArr: [],  // 要展开的菜单数组
      menuTheme: 'light', // 主题
      themeColor: '',
      pageOpenedList: [{
          title: '首页',
          path: '/dashboard',
          name: 'dashboard'
      }],
      currentPageName: '',
      currentPath: [
          {
              title: '首页',
              path: '/dashboard',
              name: 'dashboard'
          }
      ],  // 面包屑数组
      menuList: [],
      routers: [
           otherRouter,
          ...appRouter
      ],
      tagsList: [...otherRouter.children],
      messageCount: 0,
      dontCache: ['text-editor', 'artical-publish']  // 在这里定义你不想要缓存的页面的name属性值(参见路由配置router.js)
  },
  mutations: {
      showLeftMenu(state, status) {
          state.showLeftMenu = status
      },
      showLoading(state, status) {
          state.globalLoading = status
      },
      setMenus(state, menus) {
          state.menus = menus
      },
      setRules(state, rules) {
          state.rules = rules
      },
      setUsers(state, users) {
          state.users = users
      },
      setUserGroups(state, userGroups) {
          state.userGroups = userGroups
      },
      setOrganizes(state, organizes) {
          state.organizes = organizes
      },
      ADD_VISITED_VIEWS: (state, view) => {
        if (state.visitedViews.some(v => v.path === view.path)) return
        state.visitedViews.push({ name: view.name, path: view.path })
      },
      DEL_VISITED_VIEWS: (state, view) => {
        let index
        for (const [i, v] of state.visitedViews.entries()) {
          if (v.path === view.path) {
            index = i
            break
          }
        }
        state.visitedViews.splice(index, 1)
    },
    setTagsList (state, list) {
        state.tagsList.push(...list);
    },
    updateMenulist (state) {
        let accessCode = parseInt(Cookies.get('access'));
        let menuList = [];

        if(!appRouter){
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
        //console.log(menuList)
    //    alert('xxx')
        state.menuList = menuList;
    },
    changeMenuTheme (state, theme) {
        state.menuTheme = theme;
    },
    changeMainTheme (state, mainTheme) {
        state.themeColor = mainTheme;
    },
    addOpenSubmenu (state, name) {
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
    closePage (state, name) {
        state.cachePage.forEach((item, index) => {
            if (item === name) {
                state.cachePage.splice(index, 1);
            }
        });
    },
    initCachepage (state) {
        if (localStorage.cachePage) {
            state.cachePage = JSON.parse(localStorage.cachePage);
        }
    },
    removeTag (state, name) {
        state.pageOpenedList.map((item, index) => {
            if (item.name === name) {
                state.pageOpenedList.splice(index, 1);
            }
        });
    },
    pageOpenedList (state, get) {
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
    clearAllTags (state, vm) {
        state.pageOpenedList.splice(1)
        state.cachePage.length = 0
        localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)

        vm.$router.push({
            name: 'dashboard'
        })
    },
    clearOtherTags (state, vm) {
        let currentName = vm.$route.name
        let currentIndex = 0
        state.pageOpenedList.forEach((item, index) => {
            if (item.name === currentName) {
                currentIndex = index
                return
            }
        })
        if (currentIndex === 0) {
            state.pageOpenedList.splice(1)
        } else {
            state.pageOpenedList.splice(currentIndex + 1)
            state.pageOpenedList.splice(1, currentIndex - 1)
        }
        let newCachepage = state.cachePage.filter(item => {
            return item === currentName
        })
        state.cachePage = newCachepage
        localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
    },
    clearCurrentTag (state, vm) {
        let currentName = vm.$route.name

        // 首页不管
        if(currentName == 'dashboard'){
            return
        }

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
    clearRightsTag (state, vm) {
        let currentName = vm.$route.name
        let currentIndex = 0
        let find = false
        let rightName = []
        state.pageOpenedList.forEach((item, index) => {
            if (item.name === currentName) {
                currentIndex = index
                find = true
            }
            if(find === true){
                rightName.push(item.name)
            }
        })

        rightName.shift()
        if(rightName.length == 0){
            return
        }

        state.pageOpenedList.splice(currentIndex+1)
        let newCachepage = state.cachePage.filter(item => {
            return !rightName.includes(item)
        })
        state.cachePage = newCachepage
        localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
    },
    clearLeftsTag (state, vm) {
        let currentName = vm.$route.name

        // 首页不管
        if(currentName == 'dashboard'){
            return
        }

        let currentIndex = 0
        let find = false
        let leftName = []
        state.pageOpenedList.forEach((item, index) => {
            if (item.name === currentName) {
                currentIndex = index
                find = true
            }
            if(find === false && item.name != 'dashboard'){
                leftName.push(item.name)
            }
        })

        if(leftName.length == 0){
            return
        }

        state.pageOpenedList.splice(1, currentIndex - 1)
        let newCachepage = state.cachePage.filter(item => {
            return !leftName.includes(item)
        })
        state.cachePage = newCachepage
        localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
    },
    saveTagLocalStorage (state, vm) {
        localStorage.pageOpenedList = JSON.stringify(state.pageOpenedList)
    },
    setOpenedList (state) {
        state.pageOpenedList = localStorage.pageOpenedList ? JSON.parse(localStorage.pageOpenedList) : [otherRouter.children[0]]
    },
    setCurrentPath (state, pathArr) {
        state.currentPath = pathArr;
    },
    setCurrentPageName (state, name) {
        state.currentPageName = name;
    },
    setAvator (state, path) {
        localStorage.avatorImgPath = path;
    },
    switchLang (state, lang) {
        state.lang = lang;
        Vue.config.lang = lang;
    },
    clearOpenedSubmenu (state) {
        state.openedSubmenuArr.length = 0;
    },
    setMessageCount (state, count) {
        state.messageCount = count;
    },
    increateTag (state, tagObj) {
        // 刷新直接跳过
        if(tagObj.name == 'refresh'){
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
      },
      addVisitedViews({ commit }, view) {
        commit('ADD_VISITED_VIEWS', view)
      },
      delVisitedViews({ commit, state }, view) {
        return new Promise((resolve) => {
          commit('DEL_VISITED_VIEWS', view)
          resolve([...state.visitedViews])
        })
      }
  }
}

export default app
