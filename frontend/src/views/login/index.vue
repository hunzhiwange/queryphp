<template>
<div>
    <div class="login-header">
        <div class="login-inner">
            <div class="logo pull-left"><img :src="img_logo" alt="QueryPHP" /></div>
            <div class="description">{{__('用户登录')}}</div>
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
                        <TabPane :label="__('账号登录')" icon="android-person">
                            <Form ref="form" :model="form" :rules="rules" :label-width="0" label-position="left" class="login-form">
                                <FormItem prop="name">
                                    <Input type="text" v-model.trim="form.name" :placeholder="__('账号')" size="large"></Input>
                                </FormItem>
                                <FormItem prop="password">
                                    <Input type="password" v-model.trim="form.password" :placeholder="__('密码')" size="large"></Input>
                                </FormItem>
                                <FormItem prop="code">
                                    <Row>
                                        <Col span="12">
                                        <Input type="text" v-model.trim="form.code" :placeholder="__('验证码')" class="w-150" size="large"></Input>
                                        </Col>
                                        <Col span="12">
                                        <img :src="codeUrl" @click="refreshSeccode()" class="code" />
                                        </Col>
                                    </Row>
                                </FormItem>
                                <FormItem>
                                    <Checkbox v-model="checked" @on-change="keepLogin">{{__('保持登录')}}</Checkbox>
                                </FormItem>
                                <FormItem>
                                    <Button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')" size="large" long>{{__('登录')}}</Button>
                                </FormItem>
                                <FormItem>
                                    <Row>
                                        <Col span="12">
                                            <Button type="text" size="large">{{__('找回密码')}}</Button>
                                        </Col>
                                        <Col span="12" style="text-align:right;">
                                            <Button type="text" size="large">{{__('新用户注册')}}</Button>
                                        </Col>
                                    </Row>
                                </FormItem>
                            </Form>
                        </TabPane>
                        <!--<TabPane :label="__('微信扫一扫')" icon=". fa fa-weixin">
                            todo
                        </TabPane>
                        <TabPane :label="__('手机登录')" icon="android-phone-portrait">
                            todo
                        </TabPane>-->
                    </Tabs>
                </div>
                </Col>
            </Row>
        </div>
    </div>
    <div class="login-footer">
        <div class="login-inner">
            <div>© 2018 <a href="http://www.queryphp.com">QueryPHP.COM</a> All rights reserved.</div>
        </div>
    </div>
</div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
