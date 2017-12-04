import Cookies from 'js-cookie'
import global from '@/utils/global'
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
        information
    },
    data () {
        return {
            img_logo: img_logo,
            img_mini_logo: img_mini_logo,
            shrink: false,

            isFullScreen: false,
            openedSubmenuArr: this.$store.state.app.openedSubmenuArr,

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
        };
    },
    computed: {
        menuList () {
            return this.$store.state.app.menuList;
        },
        pageTagsList () {
            return this.$store.state.app.pageOpenedList;  // 打开的页面的页面对象
        },
        currentPath () {
            return this.$store.state.app.currentPath  // 当前面包屑数组
        },
        avatorPath () {
            return localStorage.avatorImgPath;
        },
        cachePage () {
            return []
            return this.$store.state.app.cachePage;
        },
        lang () {
            return this.$store.state.app.lang;
        },
        menuTheme () {
            return this.$store.state.app.menuTheme;
        },
        mesCount () {
            return this.$store.state.app.messageCount;
        }
    },
    methods: {
        init () {
            let pathArr = global.setCurrentPath(this, this.$route.name);
            this.$store.commit('updateMenulist');
            if (pathArr.length >= 2) {
                this.$store.commit('addOpenSubmenu', pathArr[1].name);
            }
            //this.userName = Cookies.get('user');
            let messageCount = 3;
            this.messageCount = messageCount.toString();
            this.checkTag(this.$route.name);
            this.$store.commit('setMessageCount', 3);
        },
        toggleClick () {
            this.shrink = !this.shrink;
        },
        logout() {
            this.$Modal.confirm({
                title:　__('提示'),
                content: __('确认退出吗?'),
                onOk: () => {
                    this.changePasswordLogout()
                },
                onCancel: () => {
                }
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
        changePassword() {
            this.$refs.changePassword.open()
        },
        information() {
            this.$refs.information.open()
        },
        handleClickUserDropdown (name) {
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
        checkTag (name) {
            let openpageHasTag = this.pageTagsList.some(item => {
                if (item.name === name) {
                    return true;
                }
            });
            if (!openpageHasTag) {  //  解决关闭当前标签后再点击回退按钮会退到当前页时没有标签的问题
                global.openNewPage(this, name, this.$route.params || {}, this.$route.query || {});
            }
        },
        handleSubmenuChange (val) {
        },
        beforePush (name) {
            return true;
        },
        fullscreenChange (isFullScreen) {
        },
        getUsername() {
            this.username = Lockr.get('userInfo').name
        }
    },
    watch: {
        '$route' (to) {
            this.$store.commit('setCurrentPageName', to.name);
            let pathArr = global.setCurrentPath(this, to.name);
            if (pathArr.length > 2) {
                this.$store.commit('addOpenSubmenu', pathArr[1].name);
            }
            this.checkTag(to.name);
            localStorage.currentPageName = to.name;
        },
        lang () {
            global.setCurrentPath(this, this.$route.name);  // 在切换语言时用于刷新面包屑
        }
    },
    mounted () {
        this.init();
    },
    created () {
        // 显示打开的页面的列表
        this.$store.commit('setOpenedList');

        let authKey = Lockr.get('authKey')
        if (!authKey) {
            _g.warning(__('未登录'))
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
    mixins: [http]
};
