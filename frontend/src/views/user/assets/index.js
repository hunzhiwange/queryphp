import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'
import search from './../search/index'

const resetForm = {
    id: null,
    name: '',
    num: '',
    status: 1,
    password: '',
}

export default {
    components: {
        search,
    },
    data() {
        var validatePassword = (rule, value, callback) => {
            if (this.formItem.id) {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入用户密码')))
                } else {
                    return callback()
                }
            }, 50)
        }

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
                    title: this.__('编号'),
                    key: 'num',
                },
                {
                    title: this.__('状态'),
                    key: 'status_enum',
                    width: 120,
                    render: (h, params) => {
                        const row = params.row
                        return <tag color={1 === row.status ? 'green' : 'red'}>{row.status_enum}</tag>
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
                                    <i-button type="text" onClick={() => this.edit(params)} disabled={!utils.permission('user_edit_button')}>
                                        {this.__('编辑')}
                                    </i-button>
                                    <i-button type="text" onClick={() => this.remove(params)} disabled={!utils.permission('user_delete_button')}>
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
            formItem: Object.assign({}, resetForm),
            minForm: false,
            rules: {
                name: [
                    {
                        required: true,
                        message: this.__('请输入用户名字'),
                    },
                ],
                num: [
                    {
                        required: true,
                        message: this.__('请输入用户编号'),
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
                password: [
                    {
                        validator: validatePassword,
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

            Object.assign(this.formItem, row)

            this.userRole = []
            row.role.forEach(item => this.userRole.push(item.id))
        },
        add: function() {
            this.minForm = true
            this.formItem.id = ''
            this.userRole = []
            this.reset()
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
            formData.userRole = this.userRole

            this.apiPost('user', formData).then(
                res => {
                    let addNode = Object.assign({}, this.formItem, res)

                    this.data.unshift(addNode)

                    this.userRole = []
                    this.loading = !this.loading
                    this.cancelMinForm(form)

                    utils.success(res.message)
                },
                () => {
                    this.loading = !this.loading
                }
            )
        },
        updateUser(form) {
            var formData = this.formItem
            formData.userRole = this.userRole

            delete formData.name

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
                () => {
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
        reset() {
            this.formItem = resetForm
        },
    },
    computed: {},
    created: function() {
        this.init()
    },
    mixins: [http],
}
