import http from '@/utils/http'

const resetFrom = {
    key: '',
    status: '',
    page: 1,
    pageSize: 10,
}

export default {
    data() {
        return {
            searchForm: Object.assign({}, resetFrom),
            searchRule: {},
            searchItem: {
                status: [
                    {status: '1', title: __('启用')},
                    {status: '0', title: __('禁用')},
                ],
            },
            searchShow: false,
        }
    },
    methods: {
        search(page, pageSize) {
            if (page) {
                this.searchForm.page = 1
            }

            if (pageSize) {
                this.searchForm.pageSize = pageSize
            }

            this.apiGet('resource', {}, this.searchForm).then(res => {
                this.$emit('getDataFromSearch', res)
            })
        },
        reset() {
            Object.assign(this.searchForm, resetFrom)
        },
        add() {
            this.$emit('add')
        },
        toggleShow() {
            this.searchShow = !this.searchShow
        },
    },
    mixins: [http],
}
