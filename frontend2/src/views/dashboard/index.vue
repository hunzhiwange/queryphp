<template>
<div class="dashboard-page">

    <Row>
        <Card>
            <p slot="title">
                <Icon type="flag"></Icon>
                The QueryPHP Vue SPA Application
            </p>
            <Button slot="extra" type="text" @click="officeSite()">官方网站</Button>
            <div>
                <Row>
                    <Col span="16">
                    <p>欢迎使用 QueryPHP Vue 单页面通用极速后台开发框架，本框架包含了基本认证、权限和账号管理功能，开发者可以在此基础上快速构建自己的应用。</p>
                    <div>
                        <div style="margin-top: 20px">
                            <Button @click="officeSite()" round>官方网站</Button>
                            <Button @click="supportSite()" round>捐 赠</Button>
                            <Button @click="githubSite()" round>Github</Button>
                        </div>
                    </div>
                    </Col>
                    <Col span="8" style="text-align:right;">
                    <Card>
                        <div style="text-align:center">
                            <img :src="logo" class="home-logo" alt="QueryPHP" />
                            <h3>The PHP Framework For Code Poem As Free As Wind</h3>
                        </div>
                    </Card>
                    </Col>
                </Row>
            </div>
        </Card>
    </Row>

    <Row class="m-t-10">
        <Card>
            <p slot="title">
                <Icon type="ios-heart"></Icon>
                二次开发说明
            </p>
            <div>
                <Row>
                    <Col span="6">
                    <Steps :current="0" direction="vertical">
                        <Step title="已完成" content="搭建开发环境"></Step>
                        <Step title="创新" content="阅读 Vue & QueryPHP 开发文档"></Step>
                        <Step title="专注" content="学习基础功能示例"></Step>
                        <Step title="分享" content="根据业务改造基础框架"></Step>
                    </Steps>
                    </Col>
                    <Col span="18">
                    <Tabs>
                        <TabPane label="综合说明" icon="social-github">
                            QueryPHP-Vue　希望为大家提供了基于 Vue 与 QueryPHP 整合的超级后台开发基础框架，以满足用户快速地理解并使用我们的产品。
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
                    </Col>
                </Row>
            </div>
        </Card>
    </Row>

    <Row class="m-t-10">
        <Alert type="success" show-icon>
            感谢信
            <p slot="desc">在这里特别鸣谢 <a href="https://github.com/honraytech/VueThink" target="_blank">VueThink</a>、<a href="https://github.com/PanJiaChen/vue-element-admin" target="_blank">VueElementAdmin</a> 和 <a href="https://github.com/iview/iview-admin" target="_blank">IViewAdmin</a>                等开源的基础框架，使得我们才能够站在巨人的肩膀上腾飞。</p>
        </Alert>
    </Row>
</div>
</template>

<script src="./js/index.js"></script>
<style src="./css/index.css"></style>
