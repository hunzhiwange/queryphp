import http from '@/utils/http'

// 组件
import shrinkableMenu from '@/views/layout/shrinkable-menu/index'
import tagsPageOpened from '@/views/layout/tags-page-opened/index'
import breadcrumbNav from '@/views/layout/breadcrumb-nav/index'
import fullScreen from '@/views/layout/fullscreen/index'
import lockScreen from '@/views/layout/lockscreen/index'
import messageTip from '@/views/layout/message-tip/index'
import themeSwitch from '@/views/layout/theme-switch/index'
import i18nSwitch from '@/views/layout/i18n-switch/index'
import changePassword from '@/views/layout/user/change_password'
import information from '@/views/layout/user/information'

// 图片
import img_logo from '@/assets/images/logo_admin_light.png'
import img_mini_logo from '@/assets/images/logo_96x96_light.png'
import avator from '@/assets/images/avator.png'

export default {
    components: {
        shrinkableMenu,
        tagsPageOpened,
        breadcrumbNav,
        fullScreen,
        lockScreen,
        messageTip,
        themeSwitch,
        i18nSwitch,
        changePassword,
        information,
    },
    data() {
        return {
            img_logo: img_logo,
            img_mini_logo: img_mini_logo,
            shrink: false,
            isFullScreen: false,
            openedSubmenuArr: this.$store.state.app.openedSubmenuArr,
            dialogVisible: false,
            avator: avator,
        }
    },
    computed: {
        menuList() {
            let menuList = this.$store.state.app.menuList

            menuList.forEach(item => {
                item.permission = utils.permission(item.name + '_menu')

                item.children.forEach(v => {
                    v.permission = utils.permission(v.name + '_menu')
                })
            })

            return menuList
        },
        pageTagsList() {
            if (localStorage.pageOpenedList) {
                this.$store.state.app.pageOpenedList = JSON.parse(localStorage.pageOpenedList)
            }

            return this.$store.state.app.pageOpenedList // 打开的页面的页面对象
        },
        currentPath() {
            return this.$store.state.app.currentPath // 当前面包屑数组
        },
        avatorPath() {
            return this.avator
        },
        cachePage() {
            return []
            return this.$store.state.app.cachePage
        },
        lang() {
            return this.$store.state.app.lang
        },
        menuTheme() {
            return this.$store.state.app.menuTheme
        },
        mesCount() {
            return this.$store.state.app.messageCount
        },
        username() {
            return this.$store.state.user.users.name
        },
    },
    methods: {
        init() {
            // 消息
            let messageCount = 3
            this.messageCount = messageCount.toString()
            this.$store.commit('setMessageCount', 3)

            // 初始化菜单
            this.$store.commit('setCurrentPageName', this.$route.name)
            let pathArr = utils.setCurrentPath(this, this.$route.name)
            if (pathArr.length > 2) {
                this.$store.commit('addOpenSubmenu', pathArr[1].name)
            }
            this.checkTag(this.$route.name)
            localStorage.currentPageName = this.$route.name

            // 菜单
            this.$store.commit('updateMenulist')

            // 刷新后台自动刷新权限，每一小时刷新一次用户权限
            this.refreshPermission()

            setInterval(() => {
                this.refreshPermission()
            }, 1000 * 60 * 60)
        },
        // 刷新权限，防止需要重新登录才刷新权限
        refreshPermission() {
            this.apiGet('user/permission', {refresh: '1'}).then(res => {
                this.$store.dispatch('setRules', res)
            })
        },
        toggleClick() {
            this.shrink = !this.shrink
        },
        logout() {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认退出吗?'),
                onOk: () => {
                    this.changePasswordLogout()
                },
                onCancel: () => {},
            })
        },
        changePasswordLogout() {
            let data = {}
            this.apiPost('login/logout', data).then(() => {
                this.$store.dispatch('logout')
                utils.success(this.__('登出成功'))
                setTimeout(() => {
                    router.replace('/login')
                }, 1000)
            })
        },
        changePassword() {
            this.$refs.changePassword.open()
        },
        information() {
            this.$refs.information.open()
        },
        handleClickUserDropdown(name) {
            switch (name) {
                case 'logout':
                    this.logout()
                    break
                case 'changePassword':
                    this.changePassword()
                    break
                case 'information':
                    this.information()
                    break
            }
        },
        checkTag(name) {
            let openpageHasTag = this.pageTagsList.some(item => {
                if (item.name === name) {
                    return true
                }
            })

            if (!openpageHasTag) {
                //  解决关闭当前标签后再点击回退按钮会退到当前页时没有标签的问题
                utils.openNewPage(this, name, this.$route.params || {}, this.$route.query || {})
            }
        },
        handleSubmenuChange() {},
        beforePush() {
            return true
        },
        fullscreenChange() {},
    },
    watch: {
        $route(to) {
            this.$store.commit('setCurrentPageName', to.name)
            let pathArr = utils.setCurrentPath(this, to.name)
            if (pathArr.length > 2) {
                this.$store.commit('addOpenSubmenu', pathArr[1].name)
            }
            this.checkTag(to.name)
            localStorage.currentPageName = to.name
        },
        lang() {
            utils.setCurrentPath(this, this.$route.name) // 在切换语言时用于刷新面包屑
        },
    },
    mounted() {
        this.init()
    },
    created() {
        this.$store.dispatch('loginStorage')
    },
    mixins: [http],
}
