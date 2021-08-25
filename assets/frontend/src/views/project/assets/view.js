import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'
import search from '../search/index'
import projectTemplate from './template'
//see https://github.com/SortableJS/Vue.Draggable
import draggable from 'vuedraggable'

const resetForm = {
    name: '',
    num: '',
    status: 1,
    template: [],
}

const resetFormCommonUser = {
    selectUser: [],
}

const resetUserForm = {
    key: '',
    project_id: null,
    page: 1,
    size: 10,
}

const resetFormUser = {}

export default {
    components: {
        search,
        draggable,
    },
    data() {
        const message = [
            "编辑订单时，确认了逻辑未变，当前订单（结算金额-已支付金额 > 客户余额）就会报客户余额不足。程序有一个bug获取已支付金额变量取错了，每次获取的支付金额一直为0，导致判断错误。",
            "委托代理合同",
            "授权委托书",
            "风险告知书",
        ];
        const message2 = [
            "案情摘要",
            "法律关系分析",
            "法律法规检索",
            "起诉状",
            "调查取证身份信息",
            "调查取证房产信息",
            "调查取证车辆信息",
            "查询其他档案",
            "开庭审理",
        ];
        const message3 = [
            "领取传票",
            "提交代理词",
            "开庭审理",
            "当事人沟通",
            "与法官沟通",
            "领取裁决书",
            "缴费立案",
            "庭前阅卷",
        ];
        const message4 = [
            "通知当事人领取裁决书并签字",
            "结案归档",

        ];
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
                    width: 250,
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
                                        v-show={!this.favorProjectIds.includes(params.row.id) && utils.permission('project_edit_button')}>
                                        {this.__('收藏')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.cancelFavor(params)}
                                        v-show={this.favorProjectIds.includes(params.row.id) && utils.permission('project_edit_button')}>
                                        {this.__('取消收藏')}
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
            formCommonUser: resetFormCommonUser,
            loadingCommonUser: false,
            commonUsers: [],
            userTotal: 0,
            userPage: 1,
            userPageSize: 10,
            userPermissionId: 0,
            userSearchKey: '',
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
                                        onClick={() => this.deleteUser(params)}
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
            commonUserRules: {
                selectUser: [
                    {
                        required: true,
                        message: this.__('请选择用户'),
                    },
                ],
            },
            favorProjectIds: [],
            projectTemplate: projectTemplate,
            seletedProjectTemplate: 'soft',
            dragList: [{
                list: message.map((name, index) => {
                    return {
                        name,
                        order: index + 1,
                        fixed: false
                    };
                }),
                order: 10001,
                name: "委托阶段",
                fixed: false
            }, {
                list: message2.map((name, index) => {
                    return {
                        name,
                        order: index + 20,
                        fixed: false
                    };
                }),
                order: 10003,
                name: "准备阶段",
                fixed: false
            }, {
                list: message3.map((name, index) => {
                    return {
                        name,
                        order: index + 40,
                        fixed: false
                    };
                }),
                order: 10005,
                name: "起诉阶段",
                fixed: false
            }, {
                list: message4.map((name, index) => {
                    return {
                        name,
                        order: index + 60,
                        fixed: false
                    };
                }),
                order: 10005,
                name: "结案阶段",
                fixed: false
            }],
            editable: true,
            order: 1000,
            single: false,
        }
    },
    methods: {
        orderList() {
            this.list = this.list.sort((one, two) => {
                return one.order - two.order;
            });
        },
        onMove({
            relatedContext,
            draggedContext
        }) {
            const relatedElement = relatedContext.element;
            const draggedElement = draggedContext.element;
            return (
                (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
            );
        },
        // 添加任务
        addTask(index) {
            var order = this.order++;
            this.dragList[index].list.push({
                name: '新增任务' + order,
                order: order,
                fixed: false
            })
        },
        // 删除任务
        delTask(index, k) {
            this.dragList[index].list.splice(k, 1);
        },
        // 添加任务阶段
        addStage() {
            var order = this.order++;
            this.dragList.push({
                'list': [],
                'order': order,
                'name': "新增任务阶段" + order,
                'fixed': false
            });
        },
        // 删除任务阶段
        delStage(index) {
            this.dragList.splice(index, 1);
        },
        getDataFromSearch(data) {
            this.data = data.data
            this.total = data.page.total_record
            this.page = data.page.current_page
            this.pageSize = data.page.per_page
            this.loadingTable = false
        },
        getProjectFavorDataFromSearch(data) {
            let favorProjectIds = []
            data.data.forEach(item => {
                favorProjectIds.push(item.id)
            })
            this.favorProjectIds = favorProjectIds
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
                    this.loadingTable = !this.loadingTable
                    this.apiDelete('project', params.row.id).then(res => {
                        this.loadingTable = !this.loadingTable
                        this.data.splice(params.index, 1)
                        utils.success(res.message)
                    }, () => {
                        this.loadingTable = !this.loadingTable
                    })
                },
                onCancel: () => {},
            })
        },
        favor(params) {
            let data = {
                project_id: params.row.id,
            }
            this.loadingTable = !this.loadingTable
            this.apiPost('project/favor', data).then(res => {
                if (!this.favorProjectIds.includes(data.project_id)) {
                    this.favorProjectIds.push(data.project_id)
                }
                this.loadingTable = !this.loadingTable
                utils.success(res.message)
            }, () => {
                this.loadingTable = !this.loadingTable
            })
        },
        cancelFavor(params) {
            let data = {
                project_id: params.row.id,
            }
            this.loadingTable = !this.loadingTable
            this.apiPost('project/cancel-favor', data).then(res => {
                if (this.favorProjectIds.includes(data.project_id)) {
                    let deleteProjectIndex = this.favorProjectIds.indexOf(data.project_id)
                    if (deleteProjectIndex > -1) {
                        this.favorProjectIds.splice(deleteProjectIndex, 1)
                    }
                }
                this.loadingTable = !this.loadingTable
                utils.success(res.message)
            }, () => {
                this.loadingTable = !this.loadingTable
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
                        this.saveProject(form)
                    } else {
                        this.updateProject(form)
                    }
                }
            })
        },
        saveProject(form) {
            var formData = this.formItem
            formData.template = this.seletedProjectTemplateData
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
            this.viewDetail = params.row
            this.minUserProjectId = params.row.id
            this.searchUser()
        },
        searchUser: function() {
            this.loadingUserTable = false
            this.searchUserForm.project_id = this.minUserProjectId
            this.apiGet('project/user', this.searchUserForm).then(res => {
                this.userData = res.data
                this.userTotal = res.page.total_record
                this.userPage = res.page.current_page
                this.userPageSize = res.page.per_page
                this.loadingUserTable != this.loadingUserTable
            })
        },
        searchCommonUser(query) {
            query = query.replace(/(^\s*)|(\s*$)/g, '')
            this.userSearchKey = query

            utils.once(() => {
                if (query !== '') {
                    this.loadingCommonUser = true
                    this.apiGet('user', {key: query, size: 9999, status: 1}).then(res => {
                        this.loadingCommonUser = false
                        this.commonUsers = res.data
                    })
                } else {
                    this.commonUsers = []
                }
            }, 500)
        },
        changeCommonUser() {},
        resetUser() {
            Object.assign(this.searchUserForm, resetUserForm)
            this.searchUser()
        },
        setMember(params) {
            var formData = {
                project_id: this.minUserProjectId,
                user_id: params.row.user_id,
            }

            this.loadingUserTable != this.loadingUserTable
            this.apiPost('project/set-member', formData).then(
                res => {
                    this.userData.forEach((item, index) => {
                        if (item.user_id === params.row.user_id) {
                            item.extend_type = res.extend_type
                            item.extend_type_enum = res.extend_type_enum
                            this.$set(this.userData, index, item)
                        }
                    })
                    this.loadingUserTable != this.loadingUserTable
                    utils.success(res.message)
                },
                () => {
                    this.loadingUserTable != this.loadingUserTable
                }
            )
        },
        setAdministrator(params) {
            var formData = {
                project_id: this.minUserProjectId,
                user_id: params.row.user_id,
            }

            this.loadingUserTable != this.loadingUserTable
            this.apiPost('project/set-administrator', formData).then(
                res => {
                    this.userData.forEach((item, index) => {
                        if (item.user_id === params.row.user_id) {
                            item.extend_type = res.extend_type
                            item.extend_type_enum = res.extend_type_enum
                            this.$set(this.userData, index, item)
                        }
                    })
                    this.loadingUserTable != this.loadingUserTable
                    utils.success(res.message)
                },
                () => {
                    this.loadingUserTable != this.loadingUserTable
                }
            )
        },
        deleteUser(params) {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认删除该成员?'),
                onOk: () => {
                    var formData = {
                        project_id: this.minUserProjectId,
                        user_id: params.row.user_id,
                    }
                    this.loadingUserTable != this.loadingUserTable
                    this.apiPost('project/delete-user', formData).then(
                        res => {
                            this.userData.splice(params.index, 1)
                            this.loadingUserTable != this.loadingUserTable
                            utils.success(res.message)
                        },
                        () => {
                            this.loadingUserTable != this.loadingUserTable
                        }
                    )
                },
                onCancel: () => {},
            })
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
        addUser() {
            this.rightForm = true
        },
        handleAddUserSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    var formData = {
                        project_id: this.minUserProjectId,
                        user_ids: this.formCommonUser.selectUser,
                    }

                    this.loading = !this.loading
                    this.loadingUserTable != this.loadingUserTable
                    this.apiPost('project/addUsers', formData).then(
                        res => {
                            this.loading = !this.loading
                            this.rightForm = false
                            this.commonUsers = []
                            this.selectUser = []
                            this.searchUser()
                            this.loadingUserTable != this.loadingUserTable
                            utils.success(res.message)
                        },
                        () => {
                            this.loading = !this.loading
                            this.loadingUserTable != this.loadingUserTable
                        }
                    )
                }
            })
        },
    },
    computed: {
        seletedProjectTemplateData: function () {
            let selecedData = this.projectTemplate.find(item => {
                return item.key === this.seletedProjectTemplate;
            })
            selecedData = selecedData || {}
            return selecedData
        },
        dragOptions() {
            return {
                animation: 1,
                group: "description",
                disabled: !this.editable,
                ghostClass: "ghost"
            };
        },
        listString() {
            return JSON.stringify(this.dragList, null, 2);
        },
    },
    mounted: function() {
        this.init()
    },
    mixins: [http],
}
