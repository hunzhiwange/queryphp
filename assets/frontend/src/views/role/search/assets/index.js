import http from '@/utils/http'

const resetForm = {
    key: '',
    status: '',
    page: 1,
    size: 10,
}

export default {
    data() {
        return {
            searchForm: Object.assign({}, resetForm),
            searchRule: {},
            searchItem: {
                status: [{value: '1', title: this.__('启用')}, {value: '0', title: this.__('禁用')}],
            },
            searchShow: false,
        }
    },
    methods: {
        search(page, pageSize) {
            if (page) {
                this.searchForm.page = page
            }

            if (pageSize) {
                this.searchForm.size = pageSize
            }

            this.apiGet('role', this.searchForm).then(res => {
                this.$emit('getDataFromSearch', res)
            })
        },
        reset() {
            Object.assign(this.searchForm, resetForm)
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
