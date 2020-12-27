import http from '@/utils/http'

export default {
    data() {
        var validateConfirmPassword = (rule, value, callback) => {
            if (value === '') {
                callback(new Error(this.__('请再次输入密码')))
            } else if (value !== this.form.new_pwd) {
                callback(new Error(this.__('两次输入密码不一致!')))
            } else {
                callback()
            }
        }

        return {
            dialogVisible: false,
            loading: false,
            form: {
                old_pwd: '',
                new_pwd: '',
                confirm_pwd: '',
            },
            rules: {
                old_pwd: [
                    {
                        required: true,
                        message: this.__('请输入旧密码'),
                        trigger: 'blur',
                    },
                    {
                        min: 6,
                        max: 30,
                        message: this.__('长度在 %d 到 %d 个字符', 6, 30),
                        trigger: 'blur',
                    },
                ],
                new_pwd: [
                    {
                        required: true,
                        message: this.__('请输入新密码'),
                        trigger: 'blur',
                    },
                    {
                        min: 6,
                        max: 30,
                        message: this.__('长度在 %d 到 %d 个字符', 6, 30),
                        trigger: 'blur',
                    },
                ],
                confirm_pwd: [
                    {
                        required: true,
                        validator: validateConfirmPassword,
                        trigger: 'blur',
                    },
                    {
                        min: 6,
                        max: 30,
                        message: this.__('长度在 %d 到 %d 个字符', 6, 30),
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
                    this.apiPost('user/change-password', this.form).then(
                        () => {
                            utils.success(this.__('修改密码后你需要从新登陆'))
                            setTimeout(() => {
                                this.$emit('logout')
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
    created() {},
    mixins: [http],
}
