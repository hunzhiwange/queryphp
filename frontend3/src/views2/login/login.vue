<template>
<div>
    <div class="login-header">
        <div class="login-inner">
            <div class="logo pull-left"><img :src="img_logo" alt="QueryPHP" /></div>
            <div class="description">用户登录</div>
        </div>
    </div>
    <div class="login-content">
        <div class="login-inner">
            <el-row>
                <el-col :span="15">
                    <div class="pull-left big-logo">
                        <img :src="img_login_banner" alt="" />
                    </div>
                </el-col>
                <el-col :span="9">

                    <i-button @click="show">Click me!</i-button>
                    <Modal v-model="visible" title="Welcome">Welcome to iView</Modal>

                    <el-tabs type="border-card" class="login-box">
                        <el-tab-pane label="账号登录">
                            <el-form :model="form" :rules="rules" ref="form" label-position="left" label-width="0px" class="login-form">
                                <el-form-item prop="name">
                                    <el-input type="text" v-model.trim="form.name" auto-complete="off" placeholder="账号"></el-input>
                                </el-form-item>
                                <el-form-item prop="password">
                                    <el-input type="password" v-model.trim="form.password" auto-complete="off" placeholder="密码"></el-input>
                                </el-form-item>
                                <el-form-item prop="seccode">
                                    <el-input type="text" v-model.trim="form.seccode" auto-complete="off" placeholder="验证码" class="w-150"></el-input>
                                    <img :src="seccodeUrl" @click="refreshSeccode()" class="seccode" />
                                </el-form-item>
                                <div @click="keepLogin">
                                    <el-checkbox v-model="checked" style="margin:0px 0px 35px 0px;">保持登录</el-checkbox>
                                </div>
                                <el-form-item style="width:100%;">
                                    <el-button type="primary" style="width:100%;" v-loading="loading" @click.native.prevent="handleSubmit('form')">登录</el-button>
                                </el-form-item>
                                <el-form-item>
                                    <!-- <el-row type="flex" class="row-bg" justify="center">
                                        <el-col :span="15" class="">
                                            <el-button type="text">找回密码</el-button>
                                        </el-col>
                                        <el-col :span="15" class="" style="text-align:right;">
                                            <el-button type="text">新用户注册</el-button>
                                        </el-col>
                                    </el-row> -->
                                </el-form-item>
                            </el-form>
                        </el-tab-pane>
                        <el-tab-pane label="微信扫一扫">微信扫一扫</el-tab-pane>
                        <el-tab-pane label="手机快捷登录">手机号</el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </div>
    </div>

    <div class="login-footer">
        <div class="login-inner">
            <div>© 2017 http://queryphp.com All rights reserved.</div>
        </div>
    </div>

</div>
</template>

<script src="./js/login.js"></script>
<style src="./css/login.css"></style>
