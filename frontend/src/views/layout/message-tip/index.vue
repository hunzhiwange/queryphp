<template>
    <div @click="showMessage" class="message-con">
        <Tooltip
            :content="value > 0 ? value + ' ' + __('条新消息') : __('无新消息')"
            placement="bottom"
        >
            <Badge :count="value" dot>
                <Icon type="ios-bell" :size="22"></Icon>
            </Badge>
        </Tooltip>
    </div>
</template>

<script src="./assets/index.js"></script>
