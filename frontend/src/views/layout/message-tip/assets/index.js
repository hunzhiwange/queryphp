export default {
    name: 'messageTip',
    props: {
        value: {
            type: Number,
            default: 0,
        },
    },
    methods: {
        showMessage() {
            utils.openNewPage(this, 'message_index')
            this.$router.push({
                name: 'message_index',
            })
        },
    },
}
