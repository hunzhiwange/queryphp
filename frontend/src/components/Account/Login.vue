<template>
<div>
    <div style="width:1200px;margin:0 auto;">
        <el-row type="flex" class="row-bg" justify="center">
            <el-col :span="16" class="header">
                <div class="inner">
                    <div class="login-logo-text pull-left">{{systemName}}</div>
                    <div class="login-logo-description">用户登录</div>
                </div>
            </el-col>
            <el-col :span="8"></el-col>
        </el-row>
    </div>
    <div style="" class="login-content">
        <div style="width:1200px;margin:0 auto;" class=".login-content">
            <el-row type="flex" class="row-bg" justify="center">
                <el-col :span="15" class="header">
                    <div class="pull-left big-logo">
                        <img src="../../assets/images/logo_queryphp.png" alt="">
                    </div>
                </el-col>
                <el-col :span="9">


                    <el-tabs type="border-card" class="login-box">
                        <el-tab-pane label="账号登录">

                            <el-form :model="form" :rules="rules2" ref="form" label-position="left" label-width="0px" class="demo-ruleForm2 card-box2 loginform">
                                <el-form-item prop="name">
                                    <el-input type="text" v-model="form.name" auto-complete="off" placeholder="账号"></el-input>
                                </el-form-item>
                                <el-form-item prop="password">
                                    <el-input type="password" v-model="form.password" auto-complete="off" placeholder="密码"></el-input>
                                </el-form-item>
                                <el-form-item v-show="requireVerify" prop="verifyCode">
                                    <el-input type="text" v-model="form.verifyCode" auto-complete="off" placeholder="验证码" class="w-150"></el-input>
                                    <img :src="verifyUrl" @click="refreshVerify()" class="verify-pos" />
                                </el-form-item>

                                <el-checkbox v-model="checked" style="margin:0px 0px 35px 0px;">记住密码</el-checkbox>


                                <el-form-item style="width:100%;">
                                    <el-button type="primary" style="width:100%;" v-loading="loading" @click.native.prevent="handleSubmit2('form')">登录</el-button>
                                </el-form-item>

                                <el-form-item>

                                    <el-row type="flex" class="row-bg" justify="center">
                                        <el-col :span="15" class="">
                                            <el-button type="text">找回密码</el-button>
                                        </el-col>
                                        <el-col :span="15" class="" style="text-align:right;">
                                            <el-button type="text">新用户注册</el-button>
                                        </el-col>
                                    </el-row>
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


    <div style="width:1200px;margin:0 auto;" class="footer">
        <el-row type="flex" class="row-bg" justify="center">
            <el-col :span="24" class="header">
                <div class="inner">
                    <div>©2017 {{systemName}} All rights reserved.</div>
                </div>
            </el-col>
        </el-row>
    </div>

</div>
</template>

<script>
import http from '../../assets/js/http'

export default {
    data() {
        return {
            title: '',
            systemName: '',
            loading: false,
            form: {
                name: '',
                password: '',
                verifyCode: ''
            },
            requireVerify: false,
            verifyUrl: '',
            verifyImg: window.HOST + 'admin/base/getVerify',
            rules2: {
                name: [{
                    required: true,
                    message: '请输入账号',
                    trigger: 'blur'
                }],
                password: [{
                    required: true,
                    message: '请输入密码',
                    trigger: 'blur'
                }],
                verifyCode: [{
                    required: false,
                    message: '请输入验证码',
                    trigger: 'blur'
                }]
            },
            checked: false,
            remember_me: 0,
            remember_time: 0
        }
    },
    methods: {
        refreshVerify() {
            this.verifyUrl = ''
            setTimeout(() => {
                this.verifyUrl = this.verifyImg + '?v=' + moment().unix()
            }, 300)
        },
        handleSubmit2(form) {
            if (this.loading) return
            this.$refs.form.validate((valid) => {
                if (valid) {
                    this.loading = !this.loading
                    let data = {}
                    if (this.requireVerify) {
                        data.name = this.form.name
                        data.password = this.form.password
                        data.verifyCode = this.form.verifyCode
                    } else {
                        data.name = this.form.name
                        data.password = this.form.password
                    }
                    if (this.checked) {
                        data.remember_me = 1
                    } else {
                        data.remember_me = 0
                    }
                    data.remember_time = this.remember_time
                    this.apiPost('admin/base/login', data).then((res) => {
                        if (res.code != 200) {
                            this.loading = !this.loading
                            this.handleError(res)
                        } else {
                            this.refreshVerify()
                            if (this.checked) {
                                Cookies.set('rememberPwd', true, {
                                    expires: 1
                                })
                            }
                            this.resetCommonData(res.data)
                            _g.toastMsg('success', '登录成功')
                        }
                    })
                } else {
                    return false
                }
            })
        },
        checkIsRememberPwd() {
            if (Cookies.get('rememberPwd')) {
                let data = {
                    remember_key: Lockr.get('rememberKey')
                }
                this.apiPost('admin/base/login', data).then((res) => {
                    this.handelResponse(res, (data) => {
                        this.resetCommonData(data)
                    })
                })
            }
        }
    },
    created() {
        this.checkIsRememberPwd()
        this.apiPost('admin/base/getConfigs').then((res) => {
            this.handelResponse(res, (data) => {
                document.title = data.SYSTEM_NAME
                this.systemName = data.SYSTEM_NAME
                this.remember_time = data.LOGIN_SESSION_VALID
                if (parseInt(data.IDENTIFYING_CODE)) {
                    this.requireVerify = true
                    this.rules2.verifyCode[0].required = true
                }
            })
        })
        this.verifyUrl = this.verifyImg
    },
    mounted() {
        window.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                this.handleSubmit2('form')
            }
        })
    },
    mixins: [http]
}
</script>

<style>
body {
    background: #ffffff;
}

.header {}

.header>.inner {
    padding-top: 25px;
}

.inner {
    width: 1120px;
    margin: 0 auto;
}

.pull-left {
    float: left;
}

.login-logo-text {
    color: #327ddc;
    font-size: 40px;
    line-height: 60px;
    font-weight: bold;
}

.login-logo-description {
    display: inline-block;
    margin-left: 10px;
    padding-left: 10px;

    color: #ccc;
    font-size: 20px;
    height: 60px;
    line-height: 60px;
}

.login-content {
    height: 580px;
    background-color: #f8f8f8;
    border-top: 1px solid #ededed;
    border-bottom: 1px solid #ededed;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, .1);
}

.login-content .el-tabs--border-card {
    -webkit-box-shadow: none;
    box-shadow: none;
}


.verify-pos {
    position: absolute;
    right: 100px;
    top: 0px;
}

.card-box {
    padding: 20px;
    /*box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);*/
    -webkit-border-radius: 5px;
    border-radius: 5px;
    -moz-border-radius: 5px;
    background-clip: padding-box;
    margin-bottom: 20px;
    background-color: #F9FAFC;
    margin: 120px auto;
    width: 400px;
    border: 2px solid #8492A6;
}

.title {
    margin: 0px auto 40px auto;
    text-align: center;
    color: #505458;
}

.big-logo {
    margin-top: 70px;
}

.big-logo img {}

.loginform {
    /*width: 350px;
	padding: 35px 35px 15px 35px;*/
    padding: 10px 0px 0px 0px;
}

.login-box {
    margin-top: 70px;
}

.login-box .el-tabs__content {
    height: 370px;
}

.footer {
    margin: 80px 0 40px 0;
    color: #999;
    text-align: center;
}
</style>
