import http from '@/utils/http'

export default {
    data() {
        return {
            searchForm: {
                key: '',
                status: '',
            },
            searchRule: {},
            searchItem: {
                status: [
                    {status: '1', title: __('启用')},
                    {status: '0', title: __('禁用')},
                ],
            },
        }
    },
    methods: {
        search(page, pageSize) {
            let data = this.searchForm

            if (!page) {
                page = 1
            }

            if (!pageSize) {
                pageSize = 10
            }

            data['page'] = page
            data['size'] = pageSize

            this.apiGet('user', {}, data).then(res => {
                this.$emit('getDataFromSearch', res)
            })
        },
        add() {
            this.$emit('add')
        },
    },
    mixins: [http],
}
