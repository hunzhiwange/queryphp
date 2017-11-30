import leftMenu from '@/views/layout/leftMenu.vue'
import changePassword from '@/views/layout/block/change_password.vue'
import information from '@/views/layout/block/information.vue'
import http from '@/utils/http'
import tabsView from '@/views/layout/TabsView'

export default {
    data() {
        return {
            username: '',
            topMenu: [],
            childMenu: [],
            menuData: [],
            hasChildMenu: false,
            menu: null,
            module: null,
            activeIndex: '1',
            activeIndex2: '1',
            dialogVisible: false,
            informationData: {
                nikename: '',
                email: '',
                mobile: ''
            }
        }
    },
    methods: {
        logout() {
            this.$confirm('确认退出吗?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then(() => {
                this.changePasswordLogout()
            }).catch(() => {

            })
        },
        changePasswordLogout(){
            _g.openGlobalLoading()
            let data = {
                authkey: Lockr.get('authKey')
            }
            this.apiPost('user/logout', data).then((res) => {
                _g.closeGlobalLoading()
                this.handelResponse(res, (data) => {
                    Lockr.rm('menus')
                    Lockr.rm('authKey')
                    Lockr.rm('authList')
                    Lockr.rm('userInfo')
                    _g.success(res.message)
                    setTimeout(() => {
                        router.replace('/login')
                    }, 1500)
                })
            })
        },
        switchTopMenu(item) {
            if (!item.child) {
                router.push(item.url)
            } else {
                router.push(item.child[0].child[0].url)
            }
        },
        handleMenu(val) {
            switch (val) {
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
        changePassword() {
            this.$refs.changePassword.open()
        },
        information() {
            this.$refs.information.open()
        },
        getUsername() {
            this.username = Lockr.get('userInfo').name
        }
    },
    created() {
        let authKey = Lockr.get('authKey')
        if (!authKey) {
            _g.warning('您尚未登录')
            setTimeout(() => {
                router.replace('/login')
            }, 1500)
            return
        }
        this.getUsername()
        let menus = Lockr.get('menus')
        this.menu = this.$route.meta.menu
        this.module = this.$route.meta.module
        this.topMenu = menus
        let userInfo = Lockr.get('userInfo')
        this.informationData.nikename = userInfo.nikename
        this.informationData.email = userInfo.email
        this.informationData.mobile = userInfo.mobile
        _(menus).forEach((res) => {
            if (res.module == this.module) {
                this.menuData = res.child
                res.selected = true
            } else {
                res.selected = false
            }
        })
    },
    computed: {
        routerShow() {
            return store.state.routerShow
        },
        showLeftMenu() {
            this.hasChildMenu = store.state.showLeftMenu
            return store.state.showLeftMenu
        }
    },
    components: {
        leftMenu,
        information,
        changePassword,
        tabsView
    },
    watch: {
        '$route' (to, from) {
            _(this.topMenu).forEach((res) => {
                if (res.module == to.meta.module) {
                    res.selected = true
                    if (!to.meta.hideLeft) {
                        this.menu = to.meta.menu
                        this.menuData = res.child
                    }
                } else {
                    res.selected = false
                }
            })
        }
    },
    mixins: [http]
}
