<template>
    <div>
        <div class="login-header">
            <div class="login-inner">
                <div class="logo pull-left">
                    <img :src="img_logo" alt="DHB168" />
                </div>
                <div class="description">{{ __('用户登陆') }}</div>
            </div>
        </div>
        <div class="login-content">
            <div class="login-inner">
                <Row>
                    <i-col span="14">
                        <div class="pull-left big-logo">
                            <img :src="img_login_banner" alt="" width="610px" />
                        </div>
                    </i-col>
                    <i-col span="10">
                        <div class="login-box">
                            <Tabs>
                                <TabPane :label="__('账号登录')" icon="android-person">
                                    <i-form
                                        ref="form"
                                        :model="form"
                                        :rules="rules"
                                        :label-width="0"
                                        label-position="left"
                                        class="login-form"
                                    >
                                        <FormItem prop="name">
                                            <i-input
                                                type="text"
                                                v-model.trim="form.name"
                                                :placeholder="__('账号')"
                                                size="large"
                                            ></i-input>
                                        </FormItem>
                                        <FormItem prop="password">
                                            <i-input
                                                type="password"
                                                v-model.trim="form.password"
                                                :placeholder="__('密码')"
                                                size="large"
                                            ></i-input>
                                        </FormItem>
                                        <FormItem prop="code">
                                            <Row>
                                                <i-col span="12">
                                                    <i-input
                                                        type="text"
                                                        v-model.trim="form.code"
                                                        :placeholder="__('验证码')"
                                                        class="w-150"
                                                        size="large"
                                                        @on-focus="refreshSeccode()"
                                                    ></i-input>
                                                </i-col>
                                                <i-col span="12" v-if="form.name">
                                                    <img
                                                        :src="codeUrl"
                                                        @click="refreshSeccode()"
                                                        class="code"
                                                        style="cursor:pointer;"
                                                    />
                                                </i-col>
                                            </Row>
                                        </FormItem>
                                        <FormItem>
                                            <Checkbox v-model="checked" @on-change="keepLogin">{{
                                                __('保持登录')
                                            }}</Checkbox>
                                        </FormItem>
                                        <FormItem>
                                            <i-button
                                                type="primary"
                                                :loading="loading"
                                                @click.native.prevent="handleSubmit('form')"
                                                size="large"
                                                long
                                                >{{ __('登录') }}</i-button
                                            >
                                        </FormItem>
                                        <!--
                                            <FormItem>
                                                <Row>
                                                    <i-col span="12">
                                                        <i-button
                                                            type="text"
                                                            size="large"
                                                            >{{
                                                                __('找回密码')
                                                            }}</i-button
                                                        >
                                                    </i-col>
                                                    <i-col
                                                        span="12"
                                                        style="text-align:right;"
                                                    >
                                                        <i-button
                                                            type="text"
                                                            size="large"
                                                            >{{
                                                                __('新用户注册')
                                                            }}</i-button
                                                        >
                                                    </i-col>
                                                </Row>
                                            </FormItem>
                                        -->
                                    </i-form>
                                </TabPane>
                                <!--
                                    <TabPane :label="__('微信扫一扫')" icon=". fa fa-weixin">
                                        todo
                                    </TabPane>
                                    <TabPane :label="__('手机登录')" icon="android-phone-portrait">
                                        todo
                                    </TabPane>
                                -->
                            </Tabs>
                        </div>
                    </i-col>
                </Row>
            </div>
        </div>
        <div class="login-footer">
            <div class="login-inner">
                <div>
                    © 2020
                    <a href="https://www.queryphp.com">QueryPHP.COM</a> All rights reserved.
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
