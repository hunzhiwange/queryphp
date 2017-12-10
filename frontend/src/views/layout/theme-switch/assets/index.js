export default {
    name: 'themeSwitch',
    data() {
        return {
            themeSelect: false,
            modalLoading: false,
            themeList: [
                {
                    name: 'black_b',
                    title: __('青蓝冰水') + '.' + __('暗夜'),
                    menu: '#ffde00',
                    element: '#2d8cf0',
                    placement: 'top'
                }, {
                    name: 'black_g',
                    title: __('千山一碧') + '.' + __('暗夜'),
                    menu: 'rgba(174, 221, 129, 1)',
                    element: '#33b976',
                    placement: 'top'
                }, {
                    name: 'black_y',
                    title: __('灿若云霞') + '.' + __('暗夜'),
                    menu: 'rgba(219, 208, 167, 1)',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'top'
                }, {
                    name: 'black_r',
                    title: __('红尘有你') + '.' + __('暗夜'),
                    menu: 'rgba(112, 149, 159, 1)',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'top'
                }, {
                    name: 'light_b',
                    title: __('青蓝冰水') + '.' + __('光天'),
                    menu: '#eeeeee',
                    element: '#2d8cf0',
                    placement: 'bottom'
                }, {
                    name: 'light_g',
                    title: __('千山一碧') + '.' + __('光天'),
                    menu: '#eeeeee',
                    element: '#33b976',
                    placement: 'bottom'
                }, {
                    name: 'light_y',
                    title: __('灿若云霞') + '.' + __('光天'),
                    menu: '#eeeeee',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'bottom'
                }, {
                    name: 'light_r',
                    title: __('红尘有你') + '.' + __('光天'),
                    menu: '#eee',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'bottom'
                }
            ]
        };
    },
    methods: {
        handleSelect() {
            this.themeSelect = true
        },
        setTheme(themeFile) {
            let menuTheme = themeFile.substr(0, 1)
            let mainTheme = themeFile.substr(-1, 1)
            if (menuTheme === 'b') {
                this.$store.commit('changeMenuTheme', 'dark')
                menuTheme = 'dark'
            } else {
                this.$store.commit('changeMenuTheme', 'light')
                menuTheme = 'light'
            }

            let path = ''
            let themeLink = document.querySelector('link[name="theme"]')
            let userName = JSON.parse(localStorage.getItem('userInfo')).name

            if (localStorage.theme) {
                let themeList = JSON.parse(localStorage.theme)
                let index = 0
                let hasThisUser = themeList.some((item, i) => {
                    if (item.userName === userName) {
                        index = i
                        return true
                    } else {
                        return false
                    }
                });
                if (hasThisUser) {
                    themeList[index].mainTheme = mainTheme
                    themeList[index].menuTheme = menuTheme
                } else {
                    themeList.push({userName: userName, mainTheme: mainTheme, menuTheme: menuTheme});
                }
                localStorage.theme = JSON.stringify(themeList)
            } else {
                localStorage.theme = JSON.stringify([
                    {
                        userName: userName,
                        mainTheme: mainTheme,
                        menuTheme: menuTheme
                    }
                ])
            }
            let stylePath = ''
            if (ENV === 'development') {
                stylePath = '/'
            } else {
                stylePath = 'dist/'
            }
            if (mainTheme !== 'b') {
                path = stylePath + mainTheme + '.css'
            } else {
                path = ''
            }
            themeLink.setAttribute('href', path)

            this.themeSelect = false

            _g.success(__('主题切换成功'))
        }
    },
    created() {
        let stylePath = '';
        if (ENV === 'development') {
            stylePath = '/'
        } else {
            stylePath = 'dist/'
        }
        let name = this.$store.state.user.users.name
        if (localStorage.theme) {
            let hasThisUser = JSON.parse(localStorage.theme).some(item => {
                if (item.userName === name) {
                    this.$store.commit('changeMenuTheme', item.menuTheme)
                    this.$store.commit('changeMainTheme', item.mainTheme)
                    return true
                } else {
                    return false
                }
            });
            if (!hasThisUser) {
                this.$store.commit('changeMenuTheme', 'light')
                this.$store.commit('changeMainTheme', 'b')
            }
        } else {
            this.$store.commit('changeMenuTheme', 'light')
            this.$store.commit('changeMainTheme', 'b')
        }
        // 根据用户设置主题
        if (this.$store.state.app.themeColor !== 'b') {
            let stylesheetPath = stylePath + this.$store.state.app.themeColor + '.css'
            let themeLink = document.querySelector('link[name="theme"]')
            themeLink.setAttribute('href', stylesheetPath)
        }
    }
}
