import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'
import Vue from 'vue'
import search from './../search/index'

export default {
    components: {
        search,
    },
    data() {
        return {
            columns: [
                {
                    type: 'selection',
                    width: 60,
                    align: 'center',
                    className: 'table-selection',
                },
                {
                    type: 'index',
                    width: 50,
                    align: 'center',
                    className: 'table-index',
                },
                {
                    title: this.__('名字'),
                    key: 'name',
                },
                {
                    title: this.__('标识符'),
                    key: 'identity',
                },
                {
                    title: this.__('状态'),
                    key: 'status_enum',
                    width: 120,
                    render: (h, params) => {
                        const row = params.row
                        return <tag color={row.status === '1' ? 'green' : 'red'}>{row.status_enum}</tag>
                    },
                },
                {
                    title: this.__('操作'),
                    key: 'action',
                    width: 130,
                    fixed: 'right',
                    align: 'left',
                    render: (h, params) => {
                        return (
                            <div>
                                <buttonGroup size="small" shape="circle">
                                    <i-button type="text" onClick={() => this.edit(params)}>
                                        {this.__('编辑')}
                                    </i-button>
                                    <i-button type="text" onClick={() => this.remove(params)}>
                                        {this.__('删除')}
                                    </i-button>
                                </buttonGroup>
                            </div>
                        )
                    },
                },
            ],
            total: 0,
            page: 1,
            pageSize: 10,
            data: [],
            loadingTable: true,
            formItem: {
                id: null,
                name: '',
                identity: '',
                status: '1',
            },
            minForm: false,
            rules: {
                name: [
                    {
                        required: true,
                        message: this.__('请输入用户名字'),
                    },
                ],
                identity: [
                    {
                        required: true,
                        message: this.__('请输入用户标识符'),
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
            },
            loading: false,
            selectedData: [],
            roles: [],
            userRole: [],
        }
    },
    methods: {
        getDataFromSearch(data) {
            this.data = data.data
            this.total = data.page.total_record
            this.loadingTable = false
        },
        edit(params) {
            let row = params.row
            this.minForm = true
            this.formItem.id = row.id

            let data = {}
            Object.keys(this.formItem).forEach(item => (data[item] = row[item]))
            this.userRole = []
            row.role.forEach(item => this.userRole.push(item.id))
            this.formItem = data
        },
        add: function() {
            this.minForm = true
            this.formItem.id = ''
        },
        remove(params) {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认删除该用户?'),
                onOk: () => {
                    this.apiDelete('user', params.row.id).then(res => {
                        utils.success(res.message)

                        this.data.splice(params.index, 1)
                    })
                },
                onCancel: () => {},
            })
        },
        statusMany(type) {
            let selected = this.selectedData

            if (!selected.length) {
                utils.warning(this.__('请勾选数据'))
                return
            }

            let data = {
                ids: selected,
                status: type,
            }

            this.apiPost('user/status', data).then(res => {
                this.data.forEach((item, index) => {
                    if (selected.includes(item.id)) {
                        this.$set(this.data[index], 'status', type)
                        this.$set(this.data[index], 'status_enum', type === '1' ? this.__('启用') : this.__('禁用'))
                    }
                })

                utils.success(res.message)
            })
        },
        onSelectionChange(data) {
            let ids = []

            data.forEach(item => ids.push(item.id))

            this.selectedData = ids
        },
        init: function() {
            this.apiGet('user').then(res => {
                this.data = res.data
                this.total = res.page.total_record
                this.loadingTable = false
            })

            this.apiGet('role').then(res => {
                this.roles = res.data
            })
        },
        handleSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    this.loading = !this.loading
                    if (!this.formItem.id) {
                        this.saveUser(form)
                    } else {
                        this.updateUser(form)
                    }
                }
            })
        },
        saveUser(form) {
            var formData = this.formItem

            this.apiPost('user', formData).then(
                res => {
                    const addNode = {
                        name: res.name,
                        identity: res.identity,
                        id: res.id,
                        status: res.status,
                        status_enum: res.status_enum,
                    }

                    this.data.unshift(addNode)

                    this.userRole = []
                    this.loading = !this.loading
                    this.cancelMinForm(form)

                    utils.success(res.message)
                },
                res => {
                    this.loading = !this.loading
                }
            )
        },
        updateUser(form) {
            var formData = this.formItem
            formData.userRole = this.userRole

            this.apiPut('user', this.formItem.id, formData).then(
                res => {
                    this.data.forEach((item, index) => {
                        if (item.id === this.formItem.id) {
                            this.$set(this.data, index, res)
                        }
                    })

                    this.userRole = []
                    this.loading = !this.loading
                    this.cancelMinForm(form)

                    utils.success(res.message)
                },
                res => {
                    this.loading = !this.loading
                }
            )
        },
        handleReset(form) {
            this.$refs[form].resetFields()
        },
        changePage(page) {
            this.page = page
            this.$refs.search.search(page, this.pageSize)
        },
        changePageSize(pageSize) {
            this.pageSize = pageSize
            this.$refs.search.search(this.page, pageSize)
        },
        cancelMinForm: function(form) {
            this.minForm = false
            this.handleReset(form)
        },
    },
    computed: {},
    created: function() {
        this.init()
    },
    mixins: [http],
}
