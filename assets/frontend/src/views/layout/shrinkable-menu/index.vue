<template>
    <div class="ivu-shrinkable-menu" @mouseover="setTmpShrink(true)" @mouseout="setTmpShrink(false)">
        <slot name="top"></slot>
        <sidebar-menu
            :shrink="tmpShrink && shrink"
            :menu-theme="theme"
            :menu-list="menuList"
            :open-names="openNames"
            @on-change="handleChange"
            @mouseover="setTmpShrink(true)"
            @mouseout="setTmpShrink(false)"
        ></sidebar-menu>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
