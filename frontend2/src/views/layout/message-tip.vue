<template>
    <div @click="showMessage" class="message-con">
        <Tooltip :content="value > 0 ? value + ' 条新消息' : '无新消息'" placement="bottom">
            <Badge :count="value" dot>
                <Icon type="ios-bell" :size="22"></Icon>
            </Badge>
        </Tooltip>
    </div>
</template>

<script>
import global from '@/utils/global.js';
export default {
    name: 'messageTip',
    props: {
        value: {
            type: Number,
            default: 0
        }
    },
    methods: {
        showMessage () {
            global.openNewPage(this, 'message_index');
            this.$router.push({
                name: 'message_index'
            });
        }
    }
};
</script>
