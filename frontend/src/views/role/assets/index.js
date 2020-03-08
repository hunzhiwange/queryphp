import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'
import search from './../search/index'

const resetForm = {
    id: null,
    name: '',
    num: '',
    status: 1,
}

const resetFormPermission = {}

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
                    width: 160,
                    fixed: 'right',
                    align: 'left',
                    render: (h, params) => {
                        return (
                            <div>
                                <buttonGroup size="small" shape="circle">
                                    <i-button
                                        type="text"
                                        onClick={() => this.edit(params)}
                                        disabled={!utils.permission('role_edit_button')}>
                                        {this.__('编辑')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.permission(params)}
                                        disabled={!utils.permission('role_permission_button')}>
                                        {this.__('授权')}
                                    </i-button>
                                    <i-button
                                        type="text"
                                        onClick={() => this.remove(params)}
                                        disabled={!utils.permission('role_delete_button')}>
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
            tableHeight: 'auto',
            loadingTable: true,
            dataBackup: null,
            formItem: Object.assign({}, resetForm),
            minForm: false,
            rules: {
                name: [
                    {
                        required: true,
                        message: this.__('请输入角色名字'),
                    },
                ],
                num: [
                    {
                        required: true,
                        message: this.__('请输入角色编号'),
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
            },
            loading: false,
            selectedData: [],
            rightForm: false,
            styles: {
                height: 'calc(100% - 55px)',
                overflow: 'auto',
                paddingBottom: '53px',
                position: 'static',
            },
            formPermission: resetFormPermission,
            viewDetail: {},
            dataTree: [],
            dataTreeInit: false,
            permissionRoleId: '',
            selectPermissionId: [],
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
        },
        add: function() {
            this.minForm = true
            this.formItem.id = ''
            this.reset()
        },
        remove(params) {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认删除该角色?'),
                onOk: () => {
                    this.apiDelete('role', params.row.id).then(res => {
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

            this.apiPost('role/status', data).then(res => {
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
            this.apiGet('role').then(res => {
                this.data = res.data
                this.total = res.page.total_record
                this.loadingTable = false
            })
        },
        handleSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    this.loading = !this.loading
                    if (!this.formItem.id) {
                        this.saveRole(form)
                    } else {
                        this.updateRole(form)
                    }
                }
            })
        },
        saveRole(form) {
            var formData = this.formItem

            this.apiPost('role', formData).then(
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
        updateRole(form) {
            var formData = this.formItem

            this.apiPut('role', this.formItem.id, formData).then(
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
        permission(params) {
            if (!this.dataTreeInit) {
                this.apiGet('permission').then(res => {
                    this.dataTree = res
                    this.dataTreeInit = true
                })
            }
            this.permissionRoleId = params.row.id
            this.viewDetail = params.row

            this.apiGet('role/' + params.row.id).then(res => {
                let selectPermissionId = []
                res.permission.forEach(item => {
                    selectPermissionId.push(item.id)
                })

                this.selectPermissionId = selectPermissionId

                this.travelTree(this.dataTree)
            })

            this.rightForm = true
        },
        travelTree(data) {
            data.forEach(item => {
                if (this.selectPermissionId.includes(item.id)) {
                    this.$set(item, 'checked', true)
                } else {
                    this.$set(item, 'checked', false)
                }

                if (item.children) {
                    this.travelTree(item.children)
                }
            })
        },
        renderContent(h, {root, node, data}) {
            const status = data.status == 'enable'
            return (
                <span class="tree-item" style="display: inline-block; width: 100%;">
                    <span
                        class="tree-item-title"
                        style={{
                            textDecoration: data.rule == 'T' ? 'none' : '2line-through',
                        }}>
                        {data.name}
                    </span>
                    <span class="tree-item-text">{data.num}</span>
                </span>
            )
        },
        handlePermissionSubmit(form) {
            this.loading = !this.loading

            let selected = this.$refs.tree.getCheckedNodes()

            let selectedIds = []
            selected.forEach(({id}) => selectedIds.push(id))

            var formData = {
                id: this.permissionRoleId,
                permission_id: selectedIds,
            }

            this.apiPost('role/permission', formData).then(
                res => {
                    this.loading = !this.loading
                    this.rightForm = false

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
