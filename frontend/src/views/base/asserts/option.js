import http from '@/utils/http'

export default {
    methods: {
        handleSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    this.loading = !this.loading

                    this.apiPost('base/option', this.formItem).then(
                        res => {
                            this.loading = !this.loading

                            utils.success(res.message)
                        },
                        res => {
                            this.loading = !this.loading
                        }
                    )
                }
            })
        },
        init: function() {
            this.apiGet('base/get-option').then(res => {
                Object.keys(this.formItem).forEach(val => {
                    this.formItem[val] = res[val]
                })
            })
        },
    },
    data() {
        return {
            formItem: {
                site_name: '',
                site_close: '1',
            },
            loading: false,
            rules: {
                site_name: [
                    {
                        required: true,
                        message: this.__('请输入站点名字'),
                    },
                ],
            },
        }
    },
    created: function() {
        this.init()
    },
    mixins: [http],
}
