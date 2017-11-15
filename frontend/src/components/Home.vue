<template>
<div>
    <el-row>
        <el-container class="panel m-w-1280">
            <el-header>
                <el-row type="flex" justify="space-between" class="menu-box">
                    <el-col :span="18">
                        <div class="fl" style="display:block;width: 138px;height:60px;overflow:hidden;">
                            <template v-if="logo_type == '1'">
	              <img :src="img" class="logo">
	            </template>
                            <template v-else>
	              <span class="logo-text">{{title}}</span>
	            </template>
                        </div>

                        <div class="fl p-l-20 p-r-20 top-menu" :class="{'top-active': menu.selected}" v-for="menu in topMenu" @click="switchTopMenu(menu)">{{menu.title}}</div>
                    </el-col>
                    <el-col :span="7" style="text-align:right;padding-right:10px;">
                        <el-dropdown @command="handleMenu" class="top-menu">
                            <span class="el-dropdown-link">
                <i class="fa fa-user" aria-hidden="true"></i> {{username}}
              </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item command="information">账号设置</el-dropdown-item>
                                <el-dropdown-item command="changePwd">修改密码</el-dropdown-item>
                                <el-dropdown-item command="logout">退出</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>

                        <el-dropdown class="top-menu">
                            <span class="el-dropdown-link">
               <i class="el-icon-setting"></i> 配置
              </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item>选项1</el-dropdown-item>
                                <el-dropdown-item>选项2</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>

                        <el-dropdown class="top-menu">
                            <span class="el-dropdown-link ">
                <el-badge :value="200" :max="99" class="system-message">
                  <i class="fa fa-bell"></i> 消息
                </el-badge>
              </span>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item>业务消息
                                    <el-badge class="mark" :value="12" /></el-dropdown-item>
                                <el-dropdown-item>系统消息
                                    <el-badge class="mark" :value="12" /></el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </el-col>
                </el-row>
            </el-header>
            <el-container>
                <el-aside width="150px">
                    <aside v-show="!showLeftMenu">
                        <leftMenu :menuData="menuData" :menu="menu" :isCollapse="isCollapse" ref="leftMenu"></leftMenu>
                    </aside>
                </el-aside>
                <el-main>
                    <section :class="{'hide-leftMenu': hasChildMenu}">
                        <el-col :span="24">
                            <transition name="fade" mode="out-in" appear>
                                <router-view v-loading="showLoading"></router-view>
                            </transition>
                        </el-col>
                    </section>
                </el-main>
            </el-container>
        </el-container>

    </el-row>

    <changePwd ref="changePwd"></changePwd>
    <information ref="information" :nikename="informationData.nikename" :email="informationData.email" :mobile="informationData.mobile"></information>
</div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity .5s
}

.fade-enter,
.fade-leave-active {
    opacity: 0
}

.panel {
    position: absolute;
    top: 0px;
    bottom: 0px;
    width: 100%;
}

.panel-top {
    height: 65px;
    line-height: 60px;
    background: #545c64;
    color: #c0ccda;
}

.panel-center {
    background: #545c64;
    position: absolute;
    top: 60px;
    bottom: 0px;
    overflow: hidden;
}

.panel-c-c {
    background: #f1f2f7;
    right: 0px;
    top: 0px;
    bottom: 0px;
    overflow-y: scroll;
    padding: 20px;
}

.logout {
    background: url(../assets/images/logout_36.png);
    background-size: contain;
    width: 20px;
    height: 20px;
    float: left;
}

.logo {
    width: 150px;
    float: left;
    margin: 10px 10px 10px 18px;
}

.logo-text {
    color: #02d629;
    font-weight: bold;
    font-size: 25px;
    color: #ffffff;
}

.tip-logout {
    float: right;
    margin-right: 20px;
    padding-top: 5px;
    cursor: pointer;
}

.admin {
    color: #c0ccda;
    text-align: center;
}

.hide-leftMenu {
    left: 0px;
}

.system-message .el-badge__content {
    margin-top: 11px;
}

.left-mini {
    width: 50px;
}

.el-menu {
    border-right: none
}

.el-header,
.el-footer {
    color: #ffffff;
    line-height: 60px;
    padding: 0 0;
    background: #327ddc;
}

.el-header .el-badge__content {
    border: none;
}

.el-header .menu-box {
    padding-left: 12px;
}


.el-header .el-dropdown-link {
    height: 60px;
    display: block;
    padding: 0 20px;
    color: #ffffff;
}

.el-header .el-dropdown-link:hover {}

.el-aside {
    background-color: #ffffff;
    color: #333;
    overflow: inherit;
    position: fixed;
    bottom: 0;
    top: 61px;
    border-right: 1px solid #ededed;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, .1);
}

.el-aside .el-submenu__title {
    font-weight: bold;
    color: #3a3d46;
}

.el-aside .el-submenu .el-menu-item {
    min-width: 0;
}

.el-main {
    background-color: transparent;
    color: #333;
    overflow: inherit;
    height: 100%;
    position: fixed;
    left: 150px;
    right: 0px;
    top: 60px;
    padding: 22px 10px;
}

.content-main {
    margin-top: -10px;
}

body>.el-container {}

.el-container:nth-child(5) .el-aside,
.el-container:nth-child(6) .el-aside {
    line-height: 260px;
}

.el-container:nth-child(7) .el-aside {
    line-height: 320px;
}


.el-row {
    margin-bottom: 20px;
    &:last-child {
        margin-bottom: 0;
    }
}

.el-col {
    border-radius: 4px;
}

.bg-purple-dark {
    background: #99a9bf;
}

.bg-purple {
    background: #d3dce6;
}

.bg-purple-light {
    background: #e5e9f2;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}

.el-menu-header {
    background: transparent;
}
</style>
<script>
import leftMenu from './Common/leftMenu.vue'
import changePwd from './Account/changePwd.vue'
import information from './Account/Information.vue'
import http from '../assets/js/http'

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
            img: '',
            title: '',
            logo_type: null,
            activeIndex: '1',
            activeIndex2: '1',
            isCollapse: false,
            leftClass: 'w-180 ovf-hd',
            sectionLeft: '180px',
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
                _g.openGlobalLoading()
                let data = {
                    authkey: Lockr.get('authKey')
                }
                this.apiPost('admin/base/logout', data).then((res) => {
                    _g.closeGlobalLoading()
                    this.handelResponse(res, (data) => {
                        Lockr.rm('menus')
                        Lockr.rm('authKey')
                        Lockr.rm('rememberKey')
                        Lockr.rm('authList')
                        Lockr.rm('userInfo')
                        Cookies.remove('rememberPwd')
                        _g.toastMsg('success', res.message)
                        setTimeout(() => {
                            router.replace('/')
                        }, 1500)
                    })
                })
            }).catch(() => {

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
                case 'changePwd':
                    this.changePwd()
                    break
                case 'information':
                    this.information()
                    break
            }
        },
        changePwd() {
            this.$refs.changePwd.open()
        },
        information() {
            this.$refs.information.open()
        },
        getTitleAndLogo() {
            this.apiPost('admin/base/getConfigs').then((res) => {
                this.handelResponse(res, (data) => {
                    document.title = data.SYSTEM_NAME
                    this.logo_type = data.LOGO_TYPE
                    this.title = data.SYSTEM_NAME
                    this.img = window.HOST + data.SYSTEM_LOGO
                })
            })
        },
        getUsername() {
            this.username = Lockr.get('userInfo').name
        }
    },
    created() {
        this.getTitleAndLogo()
        let authKey = Lockr.get('authKey')
        if (!authKey) {
            _g.toastMsg('warning', '您尚未登录')
            setTimeout(() => {
                router.replace('/')
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
        changePwd,
        information
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
</script>
