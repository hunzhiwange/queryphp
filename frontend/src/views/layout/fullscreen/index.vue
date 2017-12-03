<template>
    <div @click="handleChange" v-if="showFullScreenBtn">
        <Tooltip :content="value ? '退出全屏' : '全屏'" placement="left">
            <Icon :type="value ? 'arrow-shrink' : 'arrow-expand'"></Icon> {{value ? '退出全屏' : '全屏'}}
        </Tooltip>
    </div>
</template>

<script src="./assets/index.js"></script>
