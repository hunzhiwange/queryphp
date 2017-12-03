<template>
<div class="dashboard-page">
    <Row>
        <Card>
            <p slot="title">
                菜单管理
            </p>
            <div>
                <Row>
                    <Col span="24">
                        <Tree :data="dataTree" show-checkbox multiple></Tree>
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

<script src="./index.js"></script>
<style src="./index.css"></style>
