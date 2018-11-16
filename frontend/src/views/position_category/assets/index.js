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
                    width: 40,
                    align: 'center',
                    className: 'table-selection',
                },
                {
                    type: 'index',
                    width: 20,
                    align: 'center',
                    className: 'table-index',
                },
                {
                    title: '名字',
                    key: 'name',
                },
                {
                    title: '状态',
                    key: 'status_name',
                    width: 120,
                    render: (h, params) => {
                        const row = params.row
                        return (
                            <tag
                                type="dot"
                                color={
                                    row.status === 'enable'
                                        ? 'green'
                                        : 'default'
                                }>
                                {row.status_name}
                            </tag>
                        )
                    },
                },
                {
                    title: '操作',
                    key: 'action',
                    width: 120,
                    align: 'right',
                    render: (h, params) => {
                        return (
                            <dropdown
                                placement="bottom-end"
                                style="textAlign: left;"
                                on-on-click={name => this[name](params)}>
                                <a href="javascript:void(0)">
                                    <icon type="more" />
                                </a>
                                <dropdownMenu slot="list">
                                    <dropdownItem name="edit">
                                        <icon type="edit" /> {__('编辑')}
                                    </dropdownItem>
                                    <dropdownItem name="top">
                                        <icon type="android-arrow-dropup-circle" />{' '}
                                        {__('置顶')}
                                    </dropdownItem>
                                    <dropdownItem name="up">
                                        <icon type="arrow-up-a" />
                                        {__('上移')}
                                    </dropdownItem>
                                    <dropdownItem name="down">
                                        <icon type="arrow-down-a" />
                                        {__('下移')}
                                    </dropdownItem>
                                    <dropdownItem name="remove">
                                        <icon type="trash-b" /> {__('删除')}
                                    </dropdownItem>
                                </dropdownMenu>
                            </dropdown>
                        )
                    },
                },
            ],
            data: [],
            tableHeight: 'auto',
            loadingTable: true,
            dataBackup: null,
            formItem: {
                id: null,
                name: '',
                remark: '',
                status: true,
            },
            minForm: false,
            rules: {
                name: [
                    {
                        required: true,
                        message: __('请输入职位分类名字'),
                    },
                ],
            },
            loading: false,
        }
    },
    methods: {
        getDataFromSearch(search) {
            if (this.dataBackup === null) {
                this.dataBackup = this.data
            }

            let searchData = this.dataBackup

            if (search.key) {
                let reg = new RegExp(search.key)
                searchData = searchData.filter(item => {
                    return item.name.match(reg)
                })
            }

            if (search.status) {
                searchData = searchData.filter(item => {
                    return item.status == search.status
                })
            }

            this.data = searchData
        },
        renderContent(h, {root, node, data}) {
            const status = data.status == 'enable'
            return (
                <span
                    class="tree-item"
                    style="display: inline-block; width: 100%;">
                    <span class="tree-item-title">{data.name}</span>
                    <span
                        class="tree-item-operate"
                        style="display: inline-block;float: right;margin-right: 32px;">
                        <i-button
                            icon="plus-circled"
                            type="default"
                            shape="circle"
                            size="small"
                            style="margin-right: 8px;"
                            on-click={() => this.append(root, node, data)}
                            disabled={data.type == 'action' ? true : false}>
                            {__('子部门')}
                        </i-button>
                        <i-button
                            icon="edit"
                            type="default"
                            shape="circle"
                            size="small"
                            style="margin-right: 8px;"
                            on-click={() => this.edit(root, node, data)}>
                            {__('修改')}
                        </i-button>
                        <i-button
                            icon={status ? 'eye-disabled' : 'eye'}
                            type="default"
                            shape="circle"
                            size="small"
                            style={{
                                color: status ? '' : '#bbbec4',
                                marginRight: '8px',
                            }}
                            on-click={() =>
                                this.status(data, status ? 'disable' : 'enable')
                            }>
                            {status ? __('禁用') : __('启用')}
                        </i-button>
                        <dropdown
                            on-on-click={name => this[name](root, node, data)}
                            placement="bottom-end">
                            <i-button
                                icon="more"
                                type="default"
                                shape="circle"
                                size="small"
                            />
                            <dropdownMenu slot="list">
                                <dropdownItem name="top">
                                    <icon type="android-arrow-dropup-circle" />{' '}
                                    {__('置顶')}
                                </dropdownItem>
                                <dropdownItem name="up">
                                    <icon type="arrow-up-a" />
                                    {__('上移')}
                                </dropdownItem>
                                <dropdownItem name="down">
                                    <icon type="arrow-down-a" />
                                    {__('下移')}
                                </dropdownItem>
                                <dropdownItem
                                    name="remove"
                                    disabled={
                                        data.children &&
                                        data.children.length > 0
                                            ? true
                                            : false
                                    }>
                                    <icon type="trash-b" /> {__('删除')}
                                </dropdownItem>
                            </dropdownMenu>
                        </dropdown>
                    </span>
                </span>
            )
        },
        edit(params) {
            let row = params.row
            this.minForm = true
            this.formItem.id = row.id

            let data = {}
            Object.keys(this.formItem).forEach(item => {
                data[item] = row[item]
            })
            data.status = data.status == 'enable' ? true : false
            this.formItem = data
        },
        add: function() {
            this.minForm = true
            this.formItem.id = ''
        },
        remove(params) {
            this.$Modal.confirm({
                title: __('提示'),
                content: __('确认删除该职业分类?'),
                onOk: () => {
                    this.apiDelete('position_category', params.row.id).then(
                        res => {
                            utils.success(res.message)

                            this.data.splice(params.index, 1)
                        }
                    )
                },
                onCancel: () => {},
            })
        },
        status(nodeData, status) {
            this.apiPut('structure/enable', nodeData.id, {
                status: status,
            }).then(res => {
                this.$set(nodeData, 'status', status)
                utils.success(res.message)
            })
        },
        statusMany(type) {
            let selected = this.$refs.tree.getCheckedNodes()
            if (!selected.length) {
                utils.warning(__('请勾选数据'))
                return
            }

            let selectedIds = []
            selected.forEach(({id}) => selectedIds.push(id))

            let data = {
                ids: selectedIds,
                status: type,
            }

            this.apiPost('structure/enables', data).then(res => {
                selected.forEach((item, key) => {
                    this.$set(item, 'status', type)
                })
                utils.success(res.message)
            })
        },
        top(root, node, nodeData) {
            this.order(root, node, nodeData, 'top')
        },
        up(root, node, nodeData) {
            this.order(root, node, nodeData, 'up')
        },
        down(root, node, nodeData) {
            this.order(root, node, nodeData, 'down')
        },
        order(root, node, nodeData, type) {
            var parentKey = root.find(el => el === node).parent
            if (parentKey !== undefined) {
                var parent = root.find(el => el.nodeKey === parentKey).node
                var index = parent.children.indexOf(nodeData)
            } else {
                const nowNode = this.dataTree.find(
                    el => el.nodeKey === node.nodeKey
                )
                var index = this.dataTree.indexOf(nowNode)
            }

            switch (type) {
                case 'up':
                    if (index == 0) {
                        return
                    }
                    break
                case 'down':
                    if (index == this.dataTree.length - 1) {
                        return
                    }
                    break
                case 'top':
                    if (index == 0) {
                        return
                    }
                    break
            }

            this.apiPut('structure/order', nodeData.id, {type: type}).then(
                res => {
                    utils.success(res.message)

                    if (parentKey !== undefined) {
                        switch (type) {
                            case 'up':
                                parent.children = this.swapItems(
                                    parent.children,
                                    index,
                                    index - 1
                                )
                                break
                            case 'down':
                                parent.children = this.swapItems(
                                    parent.children,
                                    index,
                                    index + 1
                                )
                                break
                            case 'top':
                                parent.children = this.swapItems(
                                    parent.children,
                                    index,
                                    0
                                )
                                break
                        }
                    } else {
                        switch (type) {
                            case 'up':
                                this.dataTree = this.swapItems(
                                    this.dataTree,
                                    index,
                                    index - 1
                                )
                                break
                            case 'down':
                                this.dataTree = this.swapItems(
                                    this.dataTree,
                                    index,
                                    index + 1
                                )
                                break
                            case 'top':
                                this.dataTree = this.swapItems(
                                    this.dataTree,
                                    index,
                                    0
                                )
                                break
                        }
                    }
                }
            )
        },
        swapItems: function(arr, index1, index2) {
            arr[index1] = arr.splice(index2, 1, arr[index1])[0]
            return arr
        },
        init: function() {
            this.apiGet('position_category').then(res => {
                this.data = res.data
                this.loadingTable = false
            })
        },
        handleSubmit(form) {
            this.$refs[form].validate(pass => {
                if (pass) {
                    this.loading = !this.loading
                    if (!this.formItem.id) {
                        this.saveCategory(form)
                    } else {
                        this.updateCategory(form)
                    }
                }
            })
        },
        saveCategory(form) {
            this.apiPost('position_category', this.formItem).then(
                res => {
                    const addNode = {
                        name: res.data.name,
                        id: res.data.id,
                        status: res.data.status,
                        status_name: res.data.status_name,
                        remark: res.data.remark,
                    }

                    this.data.unshift(addNode)

                    this.loading = !this.loading
                    this.cancelMinForm(form)

                    utils.success(res.message)
                },
                res => {
                    this.loading = !this.loading
                }
            )
        },
        updateCategory(form) {
            this.apiPut('structure', this.formItem.id, this.formItem).then(
                res => {
                    const parentKey = this.formItem.pid[
                        this.formItem.pid.length - 1
                    ]
                    const oldParentKey = this.oldEditPid[
                        this.oldEditPid.length - 1
                    ]

                    if (parentKey === oldParentKey) {
                        this.$set(
                            this.currentParentData,
                            'name',
                            this.formItem.name
                        )
                        this.$set(
                            this.currentParentData,
                            'status',
                            this.formItem.status ? 'enable' : 'disable'
                        )
                    } else {
                        // new parent
                        if (parentKey != -1) {
                            let parent = this.nodeRoot.find(
                                el => el.node.id === parentKey
                            ).node
                            let children = parent.children || []
                            children.push(this.currentParentData)
                            this.$set(parent, 'children', children)
                            this.$set(parent, 'expand', true)
                        } else {
                            this.dataTree.push(this.currentParentData)
                        }

                        // old parent
                        if (oldParentKey != -1) {
                            let oldParent = this.nodeRoot.find(
                                el => el.node.id === oldParentKey
                            ).node
                            const index = oldParent.children.indexOf(
                                this.currentParentData
                            )
                            oldParent.children.splice(index, 1)
                            this.$set(oldParent, 'children', oldParent.children)
                            this.$set(oldParent, 'expand', false)
                        } else {
                            const index = this.dataTree.indexOf(
                                this.currentParentData
                            )
                            this.dataTree.splice(index, 1)
                        }
                    }

                    // 清空临时根节点数据，已无用
                    this.nodeRoot = []
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
        cancelMinForm: function(form) {
            this.minForm = false
            this.handleReset(form)
        },
    },
    computed: {},
    created: function() {
        this.init()
    },
    mounted: function() {},
    activated: function() {
        if (utils.needRefresh(this)) {
            this.init()
        }
    },
    mixins: [http],
}
