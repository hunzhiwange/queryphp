export default {
    name: 'themeSwitch',
    data() {
        return {
            themeSelect: false,
            modalLoading: false,
            themeList: [
                {
                    name: 'black_b',
                    title: this.__('青蓝冰水') + '.' + this.__('暗夜'),
                    menu: '#ffde00',
                    element: '#2d8cf0',
                    placement: 'top',
                },
                {
                    name: 'black_g',
                    title: this.__('千山一碧') + '.' + this.__('暗夜'),
                    menu: 'rgba(174, 221, 129, 1)',
                    element: '#33b976',
                    placement: 'top',
                },
                {
                    name: 'black_y',
                    title: this.__('灿若云霞') + '.' + this.__('暗夜'),
                    menu: 'rgba(219, 208, 167, 1)',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'top',
                },
                {
                    name: 'black_r',
                    title: this.__('红尘有你') + '.' + this.__('暗夜'),
                    menu: 'rgba(112, 149, 159, 1)',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'top',
                },
                {
                    name: 'light_b',
                    title: this.__('青蓝冰水') + '.' + this.__('光天'),
                    menu: '#eeeeee',
                    element: '#2d8cf0',
                    placement: 'bottom',
                },
                {
                    name: 'light_g',
                    title: this.__('千山一碧') + '.' + this.__('光天'),
                    menu: '#eeeeee',
                    element: '#33b976',
                    placement: 'bottom',
                },
                {
                    name: 'light_y',
                    title: this.__('灿若云霞') + '.' + this.__('光天'),
                    menu: '#eeeeee',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'bottom',
                },
                {
                    name: 'light_r',
                    title: this.__('红尘有你') + '.' + this.__('光天'),
                    menu: '#eee',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'bottom',
                },
            ],
        }
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

            if (localStorage.theme) {
                let theme = JSON.parse(localStorage.theme)
                theme.mainTheme = mainTheme
                theme.menuTheme = menuTheme
                localStorage.theme = JSON.stringify(theme)
            } else {
                localStorage.theme = JSON.stringify({
                    mainTheme: mainTheme,
                    menuTheme: menuTheme,
                })
            }
            let stylePath = '/'
            if (mainTheme !== 'b') {
                path = stylePath + mainTheme + '.css'
            } else {
                path = ''
            }
            themeLink.setAttribute('href', path)
            this.themeSelect = false

            utils.success(this.__('主题切换成功'))
        },
    },
    created() {
        let stylePath = '/'
        if (localStorage.theme) {
            let theme = JSON.parse(localStorage.theme)
            this.$store.commit('changeMenuTheme', theme.menuTheme)
            this.$store.commit('changeMainTheme', theme.mainTheme)
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
    },
}
