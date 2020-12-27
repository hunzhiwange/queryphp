<template>
    <div class="error403">
        <div class="error403-body-con">
            <Card>
                <div class="error403-body-con-title">
                    4<span class="error403-0-span"><Icon type="android-lock"></Icon></span
                    ><span class="error403-key-span"><Icon size="220" type="ios-leaf"></Icon></span>
                </div>
                <p class="error403-body-con-message">
                    You don't have permission
                </p>
                <div class="error403-btn-con">
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

<style lang="less" src="./assets/403.less"></style>
<script src="./assets/403.js"></script>
