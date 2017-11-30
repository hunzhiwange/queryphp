<template>
<div>
    <div class="m-b-20 content-title" style="position:relative;">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        </el-breadcrumb>
    </div>
    <div class="content-main2">
        <el-row>
            <el-col :span="24">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>The QueryPHP Vue SPA Application</span>
                        <el-button style="float: right; padding: 3px 0" type="text" @click="officeSite()">官网网站</el-button>
                    </div>
                    <div>
                        <el-row type="flex" class="row-bg" justify="space-between">
                            <el-col :span="16">
                                <div class="home-box">

                            <router-link to="/dashboard2">
                              SADASD
                            </router-link>
                                                        <router-link to="/introduction/index">
                                                          SADASD
                                                        </router-link>

                                    <p>欢迎使用 QueryPHP Vue 单页面通用极速后台开发框架，本框架包含了基本认证、权限和账号管理功能，开发者可以在此基础上快速构建自己的应用。</p>
                                    <div>
                                        <div style="margin-top: 20px">
                                            <el-button @click="officeSite()" round>官方网站</el-button>
                                            <el-button @click="supportSite()" round>捐 赠</el-button>
                                            <el-button @click="githubSite()" round>Github</el-button>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="8" style="text-align:right;">
                                <img src="../../assets/images/logo.png" class="home-logo" alt="QueryPHP" />
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <h1>Vue 前端开发步骤</h1>
                                <el-steps :active="1" simple>
                                    <el-step title="阅读 Vue 开发文档" icon="el-icon-success"></el-step>
                                    <el-step title="学习基础功能示例" icon="el-icon-error"></el-step>
                                    <el-step title="根据业务改造基础框架" icon="el-icon-error"></el-step>
                                </el-steps>
                                <h1>PHP 后端开发步骤</h1>
                                <el-steps :active="1" finish-status="success" simple style="margin-top: 20px">
                                    <el-step title="阅读 QueryPHP 开发文档"></el-step>
                                    <el-step title="学习基础功能示例"></el-step>
                                    <el-step title="根据业务改造基础框架"></el-step>
                                </el-steps>
                            </el-col>
                        </el-row>
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="24">
                <el-alert title="感谢信" type="success" description="感谢 VueThink 提供的基础框架，使得我们才能够站在巨人的肩膀上腾飞。" show-icon>
                </el-alert>
            </el-col>
        </el-row>
    </div>
</div>
</template>

<script src="./js/index.js"></script>
<style src="./css/index.css"></style>
