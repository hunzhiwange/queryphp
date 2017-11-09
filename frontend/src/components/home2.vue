<template>

    <el-row class="panel m-w-1280">
    <el-container style="margin-bottom:600px;">
      <el-header>
        <el-row type="flex" justify="space-between">
          <el-col :span="6"><div class="grid-content bg-purple">xxx</div></el-col>
          <el-col :span="6"><div class="grid-content bg-purple-light">xxx</div></el-col>
          <el-col :span="6"><div class="grid-content bg-purple">sdfdsf</div></el-col>
        </el-row>

      </el-header>
      <el-container>
        <el-aside width="200px">Aside</el-aside>
        <el-main>Main</el-main>
      </el-container>
    </el-container>







        <el-col :span="24" class="panel-top2">
            <el-col :span="3">
        <template v-if="logo_type == '1'">
          <img :src="img" class="logo">
        </template>
        <template v-else>
          <span class="p-l-20">{{title}}</span>
        </template>
            </el-col>
      <el-col :span="2">
        <div class="fl p-l-20 p-r-20 top-menu" @click="switchLeftCollapse()"><i class="el-icon-d-arrow-left"></i></div>
      </el-col>
            <el-col :span="12" class="ofv-hd">
                <div class="fl p-l-20 p-r-20 top-menu" :class="{'top-active': menu.selected}" v-for="menu in topMenu" @click="switchTopMenu(menu)">{{menu.title}}</div>
            </el-col>
            <el-col :span="7" class="pos-rel">
        <el-menu
          :default-active="activeIndex"
          class="el-menu-demo"
          mode="horizontal"
          @select="handleSelect"
          background-color="#545c64"
          text-color="#fff"
          active-text-color="#ffd04b">
          <el-submenu index="1">
            <template slot="title" @command="handleMenu"><i class="fa fa-user" aria-hidden="true"></i>{{username}}</template>
            <el-menu-item index="1-1" command="changePwd">修改密码</el-menu-item>
            <el-menu-item index="1-2" command="logout">退出</el-menu-item>
          </el-submenu>
          <el-submenu index="2">
            <template slot="title"><i class="el-icon-setting"></i>配置</template>
            <el-menu-item index="2-1">选项1</el-menu-item>
            <el-menu-item index="2-2">选项2</el-menu-item>
            <el-menu-item index="2-3">选项3</el-menu-item>
          </el-submenu>
          <el-submenu index="3">
            <template slot="title">
              <el-badge :value="200" :max="99" class="system-message">
                <i class="fa fa-bell"></i>消息
              </el-badge>
            </template>
            <el-menu-item index="3-1">业务消息</el-menu-item>
            <el-menu-item index="3-2">系统消息</el-menu-item>
          </el-submenu>
          <el-menu-item index="3"><a href="https://www.queryphp.com" target="_blank">官方网站</a></el-menu-item>
        </el-menu>
            </el-col>
        </el-col>
        <el-col :span="24" class="panel-center2">
      <el-collapse-transition>
            <aside :class="leftClass" v-show="!showLeftMenu">
                <leftMenu :menuData="menuData" :menu="menu" :isCollapse="isCollapse" ref="leftMenu"></leftMenu>
            </aside>
      </el-collapse-transition>
            <section class="panel-c-c2" :style="{'left': sectionLeft}" :class="{'hide-leftMenu': hasChildMenu}">
                <div class="grid-content bg-purple-light">
                    <el-col :span="24">
                        <transition name="fade" mode="out-in" appear>
                            <router-view v-loading="showLoading"></router-view>
                        </transition>
                    </el-col>
                </div>
            </section>
        </el-col>

        <changePwd ref="changePwd"></changePwd>

    </el-row>
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
        height: 60px;
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
        position: absolute;
        right: 0px;
        top: 0px;
        bottom: 0px;
        left: 180px;
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

  .el-header, .el-footer {
    background-color: #B3C0D1;
    color: #333;
    text-align: center;
    line-height: 60px;
    padding:0 0;
  }
  
  .el-aside {
    background-color: #D3DCE6;
    color: #333;
    text-align: center;
    line-height: 200px;
  }
  
  .el-main {
    background-color: #E9EEF3;
    color: #333;
    text-align: center;
    line-height: 160px;
  }
  
  body > .el-container {
    margin-bottom: 40px;
  }
  
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
</style>
<script>
  import leftMenu from './Common/leftMenu.vue'
  import changePwd from './Account/changePwd.vue'
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
        sectionLeft: '180px'
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
            authkey: Lockr.get('authKey'),
            sessionId: Lockr.get('sessionId')
          }
          this.apiPost('admin/base/logout', data).then((res) => {
            _g.closeGlobalLoading()
            this.handelResponse(res, (data) => {
              Lockr.rm('menus')
              Lockr.rm('authKey')
              Lockr.rm('rememberKey')
              Lockr.rm('authList')
              Lockr.rm('userInfo')
              Lockr.rm('sessionId')
              Cookies.remove('rememberPwd')
              _g.toastMsg('success', '退出成功')
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
        }
      },
      changePwd() {
        this.$refs.changePwd.open()
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
      },
      switchLeftCollapse() {
        this.isCollapse = !this.isCollapse
        if (this.isCollapse == true) {
          setTimeout(() => {
            this.leftClass = 'left-mini'
            this.sectionLeft = '64px'
          }, 180)
        } else {
          this.leftClass = 'w-180 ovf-hd'
          this.sectionLeft = '180px'
        }
      }
    },
    created() {
      this.getTitleAndLogo()
      let authKey = Lockr.get('authKey')
      let sessionId = Lockr.get('sessionId')
      if (!authKey || !sessionId) {
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
      changePwd
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
