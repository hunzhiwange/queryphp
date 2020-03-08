<template>
    <div class="error500">
        <div class="error500-body-con">
            <Card>
                <div class="error500-body-con-title">
                    5<span class="error500-0-span"><Icon type="social-freebsd-devil"></Icon></span
                    ><span class="error500-0-span"><Icon type="social-freebsd-devil"></Icon></span>
                </div>
                <p class="error500-body-con-message">
                    Oops! the server is wrong
                </p>
                <div class="error500-btn-con">
                    <i-button @click="goHome" size="large" style="width: 200px;" type="text">{{
                        __('返回首页')
                    }}</i-button>
                    <i-button @click="backPage" size="large" style="width: 200px;margin-left: 40px;" type="primary">{{
                        __('返回上一页')
                    }}</i-button>
                </div>
            </Card>
        </div>
    </div>
</template>

<style lang="less" src="./assets/500.less"></style>
<script src="./assets/500.js"></script>
