import global from '@/utils/global.js'

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
            global.openNewPage(this, 'message_index')
            this.$router.push({
                name: 'message_index'
            });
        }
    }
}
