import logo from '@/assets/images/logo.png'
import avator from '@/assets/images/avator.png'

export default {
    methods: {},
    computed: {
        username() {
            return this.$store.state.user.users.name
        },
        email() {
            return this.$store.state.user.users.email ? this.$store.state.user.users.email : this.__('邮件未设置')
        },
        mobile() {
            return this.$store.state.user.users.mobile ? this.$store.state.user.users.mobile : this.__('手机号未设置')
        },
    },
    data() {
        return {
            avator: avator,
        }
    },
}
