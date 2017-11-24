<template>
<div>
    <el-row>
        <el-container class="m-w-1280">
            <el-header>
                <el-row type="flex" justify="space-between" class="menu-box">
                    <el-col :span="18">
                        <div class="fl logo">
                            <span>QueryPHP</span>
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

<script src="./js/layout.js"></script>
<style src="./css/layout.css"></style>
