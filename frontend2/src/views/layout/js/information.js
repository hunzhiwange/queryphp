import http from '@/utils/http'
import validate from '@/utils/validate'

export default {
    props: [
        'nikename', 'mobile', 'email'
    ],
    data() {
        return {
            disable: false,
            dialogVisible: false,
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
                        message: '请输入有效的邮箱'
                    }
                ],
                mobile: [
                    {
                        type: 'number',
                        validator: validate.mobile,
                        required: true,
                        message: '请输入有效的手机号'
                    }
                ]
            }
        }
    },
    methods: {
        open() {
            this.dialogVisible = true
        },
        close() {
            this.dialogVisible = false
        },
        submit(form) {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.disable = !this.disable
                    this.apiPost('user/update_info', this.form).then((res) => {
                        this.handelResponse(res, (data) => {
                            _g.toastMsg('success', res.message)
                            setTimeout(() => {
                                this.disable = !this.disable
                                this.close()
                            }, 1000)
                        }, () => {
                            this.disable = !this.disable
                        })
                    })
                }
            })
        }
    },
    created() {
        this.form.nikename = this.nikename
        this.form.email = this.email
        this.form.mobile = this.mobile
    },
    mixins: [http]
}
