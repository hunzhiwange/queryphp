import http from '@/utils/http'
import {validateEmail, validateMobile} from '@/utils/validate'

export default {
    data() {
        return {
            dialogVisible: false,
            loading: false,
            form: {
                email: '',
                mobile: '',
            },
            rules: {
                email: [
                    {
                        validator: validateEmail,
                        trigger: 'blur',
                    },
                ],
                mobile: [
                    {
                        validator: validateMobile,
                        trigger: 'blur',
                    },
                ],
            },
        }
    },
    methods: {
        open() {
            this.dialogVisible = true
        },
        ok() {
            this.$refs.form.validate(pass => {
                if (pass) {
                    this.loading = true
                    this.apiPost('user/update-info', this.form).then(
                        res => {
                            utils.success(res.message)

                            let users = this.$store.state.user.users
                            users.email = this.form.email
                            users.mobile = this.form.mobile

                            this.$store.dispatch('setUsers', users)

                            setTimeout(() => {
                                this.loading = !this.loading
                                this.cancel()
                            }, 1000)
                        },
                        () => {
                            this.loading = !this.loading
                        }
                    )
                }
            })
        },
        cancel() {
            this.dialogVisible = false
        },
    },
    created() {
        let users = this.$store.state.user.users
        this.form.email = users.email
        this.form.mobile = users.mobile
    },
    mixins: [http],
}
