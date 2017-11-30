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
            <Row>
                <Col span="14">
                <div class="pull-left big-logo">
                    <img :src="img_login_banner" alt="" />
                </div>
                </Col>
                <Col span="10">
                    <div class="login-box">
                <Tabs>
                    <TabPane label="账号登录" icon="android-person">
                        <Form ref="form" :model="form" :rules="rules" :label-width="0" label-position="left" class="login-form">
                            <FormItem prop="name">
                                <Input type="text" v-model.trim="form.name" placeholder="账号" size="large"></Input>
                            </FormItem>
                            <FormItem prop="password">
                                <Input type="password" v-model.trim="form.password" placeholder="密码" size="large"></Input>
                            </FormItem>
                            <FormItem prop="seccode">
                                <Row>
                                    <Col span="12">
                                    <Input type="text" v-model.trim="form.seccode" placeholder="验证码" class="w-150" size="large"></Input>
                                    </Col>
                                    <Col span="12">
                                    <img :src="seccodeUrl" @click="refreshSeccode()" class="seccode" />
                                    </Col>
                                </Row>
                            </FormItem>
                            <FormItem>
                                <Checkbox v-model="checked">保持登录</Checkbox>
                              </FormItem>
                            <FormItem>
                                <Button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')" size="large" long>登录</Button>
                            </FormItem>
                            <FormItem>
                                <Row>
                                    <Col span="12">
                                    <Button type="text" size="large">找回密码</Button>
                                    </Col>
                                    <Col span="12" style="text-align:right;">
                                    <Button type="text" size="large">新用户注册</Button>
                                    </Col>
                                </Row>
                            </FormItem>
                        </Form>
                    </TabPane>
                    <TabPane label="微信扫一扫" icon=". fa fa-weixin">微信扫一扫</TabPane>
                    <TabPane label="手机登录" icon="android-phone-portrait">手机登录</TabPane>
                </Tabs>
            </div>
                </Col>
            </Row>
        </div>
    </div>
    <div class="login-footer">
        <div class="login-inner">
            <div>© 2017 <a href="http://www.queryphp.com">QueryPHP.COM</a> All rights reserved.</div>
        </div>
    </div>
</div>
</template>

<script src="./js/login.js"></script>
<style src="./css/login.css"></style>
