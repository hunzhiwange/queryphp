import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'
import search from '../search/index'

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

const resetUserForm = {
    key: '',
    project_id: null,
    page: 1,
    size: 10,
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
                    title: this.__('创建时间'),
                    key: 'create_at',
                },
                {
                    title: this.__('进度'),
                    key: 'progress',
                    render: (h, params) => {
                        return <Progress percent={params.row.progress/100} stroke-width={10} />
                    },
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
                    width: 235,
                    fixed: 'right',
                    align: 'left',
                    render: (h, params) => {
                        return (
                            <div>
                                <buttonGroup size="small" shape="circle">
                                    <i-button
                                        type="text"
                                        onClick={() => this.user(params)}
                                        v-show={utils.permission('project_role_button')}>
                                        {this.__('成员')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.edit(params)}
                                        v-show={utils.permission('project_edit_button')}>
                                        {this.__('设置')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.favor(params)}
                                        v-show={utils.permission('project_edit_button')}>
                                        {this.__('收藏')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.remove(params)}
                                        v-show={utils.permission('project_delete_button')}>
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
            minUser: false,
            minUserProjectId: 0,
            searchUserForm: Object.assign({}, resetUserForm),
            userTotal: 0,
            userPage: 1,
            userPageSize: 10,
            loadingUserTable: true,
            rules: {
                name: [
                    {
                        required: true,
                        message: this.__('请输入项目名字'),
                    },
                ],
                num: [
                    {
                        required: true,
                        message: this.__('请输入项目编号'),
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
            userColumns: [
                {
                    title: this.__('用户名'),
                    key: 'user.name'
                },
                {
                    title: this.__('用户编号'),
                    key: 'user.num',
                    render: (h, params) => {
                        return <tag color="default">{params.row['user.num']}</tag>
                    },
                },
                {
                    title: this.__('成员类型'),
                    key: 'extend_type_enum'
                },
                {
                    title: this.__('加入时间'),
                    key: 'create_at'
                },
                {
                    title: this.__('操作'),
                    key: 'action',
                    width: 160,
                    fixed: 'right',
                    align: 'left',
                    render: (h, params) => {
                        return (
                            <div>
                                <buttonGroup size="small" shape="circle">
                                    <i-button
                                        type="text"
                                        onClick={() => this.setMember(params)}
                                        v-show={2 === params.row.extend_type && utils.permission('project_role_button')}>
                                        {this.__('设为成员')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.setAdministrator(params)}
                                        v-show={1 === params.row.extend_type && utils.permission('project_role_button')}>
                                        {this.__('设为管理')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.remove(params)}
                                        v-show={utils.permission('project_delete_button')}>
                                        {this.__('删除')}
                                    </i-button>
                                </buttonGroup>
                            </div>
                        )
                    },
                }
            ],
            userData: [],
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
                content: this.__('确认删除该项目?'),
                onOk: () => {
                    this.apiDelete('project', params.row.id).then(res => {
                        utils.success(res.message)

                        this.data.splice(params.index, 1)
                    })
                },
                onCancel: () => {},
            })
        },
        favor(params) {
            let data = {
                project_id: params.row.id,
            }

            this.apiPost('project/favor', data).then(res => {
                utils.success(res.message)
            })
        },
        cancelFavor(params) {
            let data = {
                project_id: params.row.id,
            }

            this.apiPost('project/cancel-favor', data).then(res => {
                utils.success(res.message)
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

            this.apiPost('project/status', data).then(res => {
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
            this.apiGet('project').then(res => {
                this.data = res.data
                this.total = res.page.total_record
                this.page = res.page.current_page
                this.pageSize = res.page.per_page
                this.loadingTable = false
            })

            this.apiGet('role', {status: 1}).then(res => {
                this.roles = res.data
            })
        },
        handleSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    this.loading = !this.loading
                    if (!this.formItem.id) {
                        this.saveProject(form)
                    } else {
                        this.updateProject(form)
                    }
                }
            })
        },
        saveProject(form) {
            var formData = this.formItem
            this.apiPost('project', formData).then(
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
        updateProject(form) {
            var formData = this.formItem
            this.apiPut('project', this.formItem.id, formData).then(
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
        cancelMinUser: function() {
            this.minUser = false
        },
        user: function(params) {
            this.minUser = true
            this.minUserProjectId = params.row.id
            this.searchUser()
        },
        searchUser: function() {
            this.loadingUserTable = true
            this.searchUserForm.project_id = this.minUserProjectId
            this.apiGet('project/user', this.searchUserForm).then(res => {
                this.userData = res.data
                this.userTotal = res.page.total_record
                this.userPage = res.page.current_page
                this.userPageSize = res.page.per_page
                this.loadingUserTable = false
            })
        },
        resetUser() {
            Object.assign(this.searchUserForm, resetUserForm)
            this.searchUser()
        },
        setMember(params) {
            var formData = {
                project_id: this.minUserProjectId,
                user_id: params.row.user_id,
            }

            this.apiPost('project/set-member', formData).then(
                res => {
                    this.userData.forEach((item, index) => {
                        if (item.user_id === params.row.user_id) {
                            item.extend_type = res.extend_type
                            item.extend_type_enum = res.extend_type_enum
                            this.$set(this.userData, index, item)
                        }
                    })

                    utils.success(res.message)
                },
                () => {
                }
            )
        },
        setAdministrator(params) {
            var formData = {
                project_id: this.minUserProjectId,
                user_id: params.row.user_id,
            }

            this.apiPost('project/set-administrator', formData).then(
                res => {
                    this.userData.forEach((item, index) => {
                        if (item.user_id === params.row.user_id) {
                            item.extend_type = res.extend_type
                            item.extend_type_enum = res.extend_type_enum
                            this.$set(this.userData, index, item)
                        }
                    })

                    utils.success(res.message)
                },
                () => {
                }
            )
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

            this.apiPost('project/role', formData).then(
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
    created: function() {
        this.init()
    },
    mixins: [http],
}
