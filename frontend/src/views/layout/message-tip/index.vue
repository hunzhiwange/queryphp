<template>
    <div @click="showMessage" class="message-con">
        <Tooltip :content="value > 0 ? value + ' ' + __('条新消息') : __('无新消息')" placement="bottom">
            <Badge :count="value" dot> <Avatar shape="circle" style="background-color: transparent;" icon="ios-notifications-outline" size="large" /> </Badge>
        </Tooltip>
    </div>
</template>

<script src="./assets/index.js"></script>
