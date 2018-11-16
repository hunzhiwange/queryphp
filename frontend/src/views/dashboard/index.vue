<template>
    <div class="dashboard-page body">
        <Row>
            <Card>
                <p slot="title">
                    <Icon type="flag"></Icon>
                    The QueryPHP Vue SPA Application
                </p>
                <i-button slot="extra" type="text" @click="officeSite();">{{
                    __('官方网站')
                }}</i-button>
                <div>
                    <Row :gutter="16">
                        <i-col span="15">
                            <p>
                                {{
                                    __(
                                        '欢迎使用 QueryPHP Vue 单页面通用极速后台开发框架，本框架包含了基本认证、权限和账号管理功能，开发者可以在此基础上快速构建自己的应用。'
                                    )
                                }}
                            </p>
                            <div>
                                <div style="margin-top: 20px">
                                    <i-button @click="officeSite();" round>{{
                                        __('官方网站')
                                    }}</i-button>
                                    <i-button @click="supportSite();" round>{{
                                        __('捐赠')
                                    }}</i-button>
                                    <i-button @click="githubSite();" round
                                        >Github</i-button
                                    >
                                </div>
                            </div>
                        </i-col>
                        <i-col span="9" style="text-align:right;">
                            <Card>
                                <div style="text-align:center">
                                    <img
                                        :src="logo"
                                        class="home-logo"
                                        alt="QueryPHP"
                                    />
                                    <h3>
                                        The PHP Framework For Code Poem As Free
                                        As Wind
                                    </h3>
                                </div>
                            </Card>
                        </i-col>
                    </Row>
                </div>
            </Card>
        </Row>

        <Row class="m-t-10">
            <Card>
                <p slot="title">
                    <Icon type="ios-heart"></Icon>
                    {{ __('二次开发说明') }}
                </p>
                <div>
                    <Row>
                        <i-col span="6">
                            <Steps :current="0" direction="vertical">
                                <Step
                                    :title="__('已完成')"
                                    :content="__('搭建开发环境')"
                                ></Step>
                                <Step
                                    :title="__('创新')"
                                    :content="
                                        __('阅读 Vue & QueryPHP 开发文档')
                                    "
                                ></Step>
                                <Step
                                    :title="__('专注')"
                                    :content="__('学习基础功能示例')"
                                ></Step>
                                <Step
                                    :title="__('分享')"
                                    :content="__('根据业务改造基础框架')"
                                ></Step>
                            </Steps>
                        </i-col>
                        <i-col span="18">
                            <Tabs>
                                <TabPane
                                    :label="__('综合说明')"
                                    icon="social-github"
                                >
                                    {{
                                        __(
                                            'QueryPHP-Vue　希望为大家提供了基于 Vue 与 QueryPHP 整合的超级后台开发基础框架，以满足用户快速地理解并使用我们的产品。'
                                        )
                                    }}
                                </TabPane>
                                <TabPane label="IView" icon="social-javascript">
                                    IView
                                </TabPane>
                                <TabPane label="Vue" icon="social-javascript">
                                    Vue
                                </TabPane>
                                <TabPane label="QueryPHP" icon="social-codepen">
                                    QueryPHP
                                </TabPane>
                            </Tabs>
                        </i-col>
                    </Row>
                </div>
            </Card>
        </Row>

        <Row class="m-t-10">
            <Alert type="success" show-icon>
                {{ __('感谢信') }}
                <p slot="desc">
                    {{
                        __(
                            '在这里特别鸣谢 %s、%s 和 %s 等开源的基础框架，使得我们才能够站在巨人的肩膀上腾飞。',
                            'VueThink',
                            'VueElementAdmin',
                            'IViewAdmin'
                        )
                    }}
                    <a
                        href="https://github.com/honraytech/VueThink"
                        target="_blank"
                        >VueThink</a
                    >、<a
                        href="https://github.com/PanJiaChen/vue-element-admin"
                        target="_blank"
                        >VueElementAdmin</a
                    >、<a
                        href="https://github.com/iview/iview-admin"
                        target="_blank"
                        >IViewAdmin</a
                    >
                </p>
            </Alert>
        </Row>
    </div>
</template>

<script src="./assets/index.js"></script>
<style src="./assets/index.css"></style>
