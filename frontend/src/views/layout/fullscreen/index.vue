<template>
    <div @click="handleChange" v-if="showFullScreenBtn">
        <Tooltip :content="value ? __('退出全屏') : __('全屏')" placement="left">
            <Icon :type="value ? 'arrow-shrink' : 'arrow-expand'"></Icon> {{value ? __('退出全屏') : __('全屏')}}
        </Tooltip>
    </div>
</template>

<script src="./assets/index.js"></script>
