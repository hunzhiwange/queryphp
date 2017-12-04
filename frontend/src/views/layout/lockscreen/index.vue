<template>
    <div @click="lockScreen">
        <Tooltip :content="__('锁屏')" placement="left">
            <Icon type="locked"></Icon> {{__('锁屏')}}
        </Tooltip>
    </div>
</template>

<script src="./assets/index.js"></script>
