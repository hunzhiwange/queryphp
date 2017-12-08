import http from '@/utils/http'
import validate from '@/utils/validate'

export default {
    props: [
        'nikename', 'mobile', 'email'
    ],
    data() {
        return {
            dialogVisible: false,
            loading: false,
            form: {
                nikename: '',
                email: '',
                mobile: ''
            },
            rules: {
                nikename: [
                    {
                        required: true,
                        validator: validate.chineseAlphaDash
                    }
                ],
                email: [
                    {
                        type: 'email',
                        required: true,
                        message: __('请输入有效的邮箱')
                    }
                ],
                mobile: [
                    {
                        type: 'number',
                        validator: validate.mobile,
                        required: true,
                        message: __('请输入有效的手机号')
                    }
                ]
            }
        }
    },
    methods: {
        open() {
            this.dialogVisible = true
        },
        ok() {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.loading = true
                    this.apiPost('user/update_info', this.form).then((res) => {
                        _g.success(res.message)
                        setTimeout(() => {
                            this.loading = !this.loading
                            this.cancel()
                        }, 1000)
                    }, (res) => {
                            this.loading = !this.loading
                        })
                }
            })
        },
        cancel() {
            this.dialogVisible = false
        }
    },
    created() {
        this.form.nikename = this.nikename
        this.form.email = this.email
        this.form.mobile = this.mobile
    },
    mixins: [http]
}
