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

const resetFormRole = {
    id: 0,
    role: [],
}

export default {
    components: {
        search,
    },
    data() {
        var passwordRule = [
            {
                required: true,
                message: this.__('请输入密码'),
                trigger: 'blur',
            },
            {
                min: 6,
                max: 30,
                message: this.__('长度在 %d 到 %d 个字符', 6, 30),
                trigger: 'blur',
            },
            {
                validator: validateAlphaDash,
            },
        ]

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
                    width: 55,
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
                    render: (h, params) => {
                        return <tag color="default">{params.row.num}</tag>
                    },
                },
                {
                    title: this.__('角色'),
                    key: 'num',
                    render: (h, params) => {
                        return (
                            <div>
                                {
                                    params.row.role.map(item =>{
                                        return <Tag color="green">{item.name}</Tag>
                                    })
                                }
                            </div>
                        )
                    },
                },
                {
                    title: this.__('创建时间'),
                    key: 'create_at',
                },
                {
                    title: this.__('状态'),
                    key: 'status_enum',
                    width: 120,
                    render: (h, params) => {
                        return <Badge status={1 === params.row.status ? 'success' : 'default'} text={params.row.status_enum} />
                    },
                },
                {
                    title: this.__('操作'),
                    key: 'action',
                    width: 185,
                    fixed: 'right',
                    align: 'left',
                    render: (h, params) => {
                        return (
                            <div>
                                <buttonGroup size="small" shape="circle">
                                    <i-button
                                        type="text"
                                        onClick={() => this.edit(params)}
                                        v-show={utils.permission('user_edit_button')}>
                                        {this.__('编辑')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.role(params)}
                                        v-show={utils.permission('user_role_button')}>
                                        {this.__('授权')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.remove(params)}
                                        v-show={utils.permission('user_delete_button')}>
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
                password: passwordRule,
                passwordBackup: passwordRule,
            },
            loading: false,
            selectedData: [],
            roles: [],
            viewDetail: {},
            rightForm: false,
            styles: {
                height: 'calc(100% - 55px)',
                overflow: 'auto',
                paddingBottom: '53px',
                position: 'static',
            },
            formRole: resetFormRole,
            selectRole: [],
        }
    },
    methods: {
        getDataFromSearch(data) {
            this.data = data.data
            this.total = data.page.total_record
            this.page = data.page.current_page
            this.pageSize = data.page.per_page
            this.loadingTable = false
        },
        edit(params) {
            let row = params.row
            this.minForm = true
            this.formItem.id = row.id
            Object.assign(this.formItem, row)
        },
        add: function() {
            this.minForm = true
            this.formItem.id = ''
            this.reset()
        },
        remove(params) {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认删除该用户?'),
                onOk: () => {
                    this.loadingTable = !this.loadingTable
                    this.apiDelete('user', params.row.id).then(res => {
                        this.data.splice(params.index, 1)
                        this.loadingTable = !this.loadingTable
                        utils.success(res.message)
                    }, () => {
                        this.loadingTable = !this.loadingTable
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
                        this.$set(this.data[index], 'status_enum', 1 === type ? this.__('启用') : this.__('禁用'))
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
            this.$refs.search.search()

            this.apiGet('role', {status: 1}).then(res => {
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
                    let addNode = Object.assign({}, this.formItem, res)

                    this.data.unshift(addNode)
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
            this.apiPut('user', this.formItem.id, formData).then(
                res => {
                    this.data.forEach((item, index) => {
                        if (item.id === this.formItem.id) {
                            this.$set(this.data, index, res)
                        }
                    })

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
        passwordValidate(id) {
            if (id) {
                this.liveNode = false
                if (this.formItem.password) {
                    this.rules.password = this.rules.passwordBackup
                } else {
                    this.rules.password = []
                }
                this.liveNode = true
            }
        },
        role(params) {
            this.viewDetail = params.row
            this.formRole.id = params.row.id
            var role = []
            params.row.role.forEach(item => {
                role.push(item.id)
            })
            this.formRole.role = role

            this.rightForm = true
        },
        handleRoleSubmit(form) {
            this.loading = !this.loading

            var formData = {
                id: this.formRole.id,
                role_id: this.formRole.role,
            }

            this.apiPost('user/role', formData).then(
                res => {
                    this.loading = !this.loading
                    this.rightForm = false

                    this.data.forEach((item, index) => {
                        if (item.id === this.formRole.id) {
                            this.$set(this.data, index, res)
                        }
                    })

                    utils.success(res.message)
                },
                () => {
                    this.loading = !this.loading
                }
            )
        },
    },
    computed: {},
    mounted: function() {
        this.init()
    },
    mixins: [http],
}
