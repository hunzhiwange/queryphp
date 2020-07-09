export default {
    name: 'themeSwitch',
    data() {
        return {
            themeSelect: false,
            modalLoading: false,
            themeList: [
                {
                    name: 'black_blue',
                    title: this.__('青蓝冰水') + '.' + this.__('暗夜'),
                    menu: '#ffde00',
                    element: '#2d8cf0',
                    placement: 'top',
                },
                {
                    name: 'black_green',
                    title: this.__('千山一碧') + '.' + this.__('暗夜'),
                    menu: 'rgba(174, 221, 129, 1)',
                    element: '#33b976',
                    placement: 'top',
                },
                {
                    name: 'black_yellow',
                    title: this.__('灿若云霞') + '.' + this.__('暗夜'),
                    menu: 'rgba(219, 208, 167, 1)',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'top',
                },
                {
                    name: 'black_red',
                    title: this.__('红尘有你') + '.' + this.__('暗夜'),
                    menu: 'rgba(112, 149, 159, 1)',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'top',
                },
                {
                    name: 'light_blue',
                    title: this.__('青蓝冰水') + '.' + this.__('青天'),
                    menu: '#eeeeee',
                    element: '#2d8cf0',
                    placement: 'bottom',
                },
                {
                    name: 'light_green',
                    title: this.__('千山一碧') + '.' + this.__('青天'),
                    menu: '#eeeeee',
                    element: '#33b976',
                    placement: 'bottom',
                },
                {
                    name: 'light_yellow',
                    title: this.__('灿若云霞') + '.' + this.__('青天'),
                    menu: '#eeeeee',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'bottom',
                },
                {
                    name: 'light_red',
                    title: this.__('红尘有你') + '.' + this.__('青天'),
                    menu: '#eee',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'bottom',
                },
                {
                    name: 'black_jirablue',
                    title: this.__('JIRA 经典蓝') + '.' + this.__('暗夜'),
                    menu: '#ffde00',
                    element: '#205081',
                    placement: 'top',
                },
                {
                    name: 'black_cyan',
                    title: this.__('青春绽放') + '.' + this.__('暗夜'),
                    menu: '#ffde00',
                    element: '#10a082',
                    placement: 'top',
                },
                {
                    name: 'light_jirablue',
                    title: this.__('JIRA 经典蓝') + '.' + this.__('青天'),
                    menu: '#eee',
                    element: '#205081',
                    placement: 'bottom',
                },
                {
                    name: 'light_cyan',
                    title: this.__('青春绽放') + '.' + this.__('青天'),
                    menu: '#eee',
                    element: '#10a082',
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
            let theme = themeFile.split('_')
            let menuTheme = theme[0]
            let mainTheme = theme[1]
            if (menuTheme === 'black') {
                this.$store.commit('changeMenuTheme', 'dark')
                menuTheme = 'dark'
            } else {
                this.$store.commit('changeMenuTheme', 'light')
                menuTheme = 'light'
            }

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

            let path = '/' + mainTheme + '.css'
            let themeLink = document.querySelector('link[name="theme"]')
            themeLink.setAttribute('href', path)

            let menuPath = '/' + mainTheme + '_' + menuTheme + '.css'
            let menuThemeLink = document.querySelector('link[name="menuTheme"]')
            menuThemeLink.setAttribute('href', menuPath)

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
            this.$store.commit('changeMainTheme', 'blue')
        }
        // 根据用户设置主题
        let stylesheetPath = stylePath + this.$store.state.app.themeColor + '.css'
        let themeLink = document.querySelector('link[name="theme"]')
        themeLink.setAttribute('href', stylesheetPath)

        let stylesheetMenuPath =
            stylePath + this.$store.state.app.themeColor + '_' + this.$store.state.app.menuTheme + '.css'
        let menuThemeLink = document.querySelector('link[name="menuTheme"]')
        menuThemeLink.setAttribute('href', stylesheetMenuPath)
    },
}
