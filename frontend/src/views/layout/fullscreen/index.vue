<template>
    <div @click="handleChange" v-if="showFullScreenBtn">
        <Icon :type="value ? 'md-contract' : 'md-expand'"></Icon>
        {{ value ? __('退出全屏') : __('全屏') }}
    </div>
</template>

<script src="./assets/index.js"></script>
