import http from '@/utils/http'

export default {
    data() {
        return {
            formItem: {
                id: null,
                pid: [-1],
                title: '',
                name: '',
                path: '',
                status: true,
                component: '',
                icon: '',
                app: '',
                controller: '',
                action: '',
                button: false
            },
            pidOptions: [],
            oldEditPid: [],
            pidDisabled: true,
            currentParentData: null,
            minForm: false,
            rules: {
                title: [{
                    required: true,
                    message: __('请输入菜单标题')
                }],
                component: [{
                    required: true,
                    message: __('请填写菜单模块')
                }]
            },
            dataTree: [],
            loading: false,
            nodeRoot: [],
            loadingSynchrodata: false,
            synchrodataReplace: false
        }
    },
    methods: {
        renderContent(h, {root, node, data}) {
            const status = data.status == 'enable'
            return (<span class='tree-item' style='display: inline-block; width: 100%;'>
                <span class='tree-item-title'>{data.title}</span>
                <span class='tree-item-operate' style='display: inline-block;float: right;margin-right: 32px;'>
                    <i-button icon='plus-circled' type='default' shape="circle" size='small' style='margin-right: 8px;' on-click={() => this.append(root, node, data)}>{__('子菜单')}</i-button>
                    <i-button icon='edit' type='default' shape="circle" size='small' style='margin-right: 8px;' on-click={() => this.edit(root, node, data)}>{__('修改')}</i-button>
                    <i-button icon={status
                            ? 'eye-disabled'
                            : 'eye'} type='default' shape="circle" size='small' style={{
                            color: status
                                ? ''
                                : '#bbbec4',
                            marginRight: '8px'
                        }} on-click={() => this.status(
                            data, status
                            ? 'disable'
                            : 'enable')}>{
                            status
                                ? __('禁用')
                                : __('启用')
                        }</i-button>
                    <dropdown on-on-click={(name) => this[name](root, node, data)} placement="bottom-end">
                        <i-button icon='more' type='default' shape="circle" size='small'></i-button>
                        <dropdownMenu slot="list">
                            <dropdownItem name="top">
                                <icon type='android-arrow-dropup-circle'></icon> {__('置顶')}</dropdownItem>
                            <dropdownItem name="up">
                                <icon type='arrow-up-a'></icon>{__('上移')}</dropdownItem>
                            <dropdownItem name="down">
                                <icon type='arrow-down-a'></icon>{__('下移')}</dropdownItem>
                            <dropdownItem name="remove" disabled={data.children && data.children.length > 0
                                    ? true
                                    : false}>
                                <icon type='trash-b'></icon> {__('删除')}</dropdownItem>
                        </dropdownMenu>
                    </dropdown>
                </span>
            </span>)
        },
        edit(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData
            this.formItem.id = nodeData.id
            this.nodeRoot = root

            this.apiGet('menu/' + nodeData.id + '/edit').then((res) => {
                let data = res.data
                if (!data.menu_type) {
                    data.menu_type = 1
                }
                data.menu_type = data.menu_type.toString()
                data.status = data.status == 'enable'
                    ? true
                    : false
                data.button = data.button == 'T'
                    ? true
                    : false
                this.formItem = data

                let pidOptions = this.getArraySelect(this.dataTree)
                pidOptions.unshift({value: -1, label: __('根菜单')})
                this.pidOptions = pidOptions
                let parentID = this.getParentID(root, nodeData).reverse()
                parentID.pop()
                if (parentID.length == 0) {
                    parentID = [-1]
                }

                setTimeout(() => {
                    this.pidDisabled = false
                    this.oldEditPid = this.formItem.pid = parentID
                }, 0)
            })
        },
        append(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData

            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: __('根菜单')})
            this.pidOptions = pidOptions
            let parentID = this.getParentID(root, nodeData).reverse()
            setTimeout(() => {
                this.formItem.pid = parentID
            })
        },
        getParentID(root, nodeData) {
            let result = [nodeData.id]

            const parentKey = root.find(el => el.nodeKey === nodeData.nodeKey).parent
            if (parentKey !== undefined) {
                const parent = root.find(el => el.nodeKey === parentKey).node
                result = result.concat(this.getParentID(root, parent))
            }

            return result
        },
        addMenu: function() {
            this.minForm = true
            this.currentParentData = null

            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: __('根菜单')})
            this.pidOptions = pidOptions
            setTimeout(() => {
                this.formItem.pid = [-1]
            })
        },
        remove(root, node, nodeData) {
            if (node.children && node.children.length > 0) {
                return
            }

            this.$Modal.confirm({
                title: __('提示'),
                content: __('确认删除该菜单?'),
                onOk: () => {
                    this.apiDelete('menu/', nodeData.id).then((res) => {
                        _g.success(res.message)

                        const parentKey = root.find(el => el === node).parent
                        if (parentKey !== undefined) {
                            const parent = root.find(el => el.nodeKey === parentKey).node
                            const index = parent.children.indexOf(nodeData)
                            parent.children.splice(index, 1)
                        } else {
                            const nowNode = this.dataTree.find(el => el.nodeKey === node.nodeKey)
                            const index = this.dataTree.indexOf(nowNode)
                            this.dataTree.splice(index, 1)
                        }
                    })
                },
                onCancel: () => {}
            })
        },
        status(nodeData, status) {
            this.apiPut('menu/enable/', nodeData.id, {status: status}).then((res) => {
                this.$set(nodeData, 'status', status)
                _g.success(res.message)
            })
        },
        statusMany(type) {
            let selected = this.$refs.tree.getCheckedNodes()
            if (!selected.length) {
                _g.warning(__('请勾选数据'))
                return
            }

            let selectedIds = []
            selected.forEach(({id}) => selectedIds.push(id))

            let data = {
                ids: selectedIds,
                status: type
            }

            this.apiPost('menu/enables', data).then((res) => {
                selected.forEach((item, key) => {
                    this.$set(item, 'status', type)
                })
                _g.success(res.message)
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
                const nowNode = this.dataTree.find(el => el.nodeKey === node.nodeKey)
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

            this.apiPut('menu/order/', nodeData.id, {type: type}).then((res) => {
                _g.success(res.message)

                if (parentKey !== undefined) {
                    switch (type) {
                        case 'up':
                            parent.children = this.swapItems(parent.children, index, index - 1)
                            break;
                        case 'down':
                            parent.children = this.swapItems(parent.children, index, index + 1)
                            break;
                        case 'top':
                            parent.children = this.swapItems(parent.children, index, 0)
                            break
                    }
                } else {
                    switch (type) {
                        case 'up':
                            this.dataTree = this.swapItems(this.dataTree, index, index - 1)
                            break;
                        case 'down':
                            this.dataTree = this.swapItems(this.dataTree, index, index + 1)
                            break;
                        case 'top':
                            this.dataTree = this.swapItems(this.dataTree, index, 0)
                            break
                    }
                }
            })
        },
        swapItems: function(arr, index1, index2) {
            arr[index1] = arr.splice(index2, 1, arr[index1])[0]
            return arr
        },
        init: function() {
            this.apiGet('menu').then((res) => {
                this.dataTree = res.data
            })
        },
        getArraySelect(data) {
            let result = []
            data.forEach(({id, title, children}) => {
                let item = {
                    value: id,
                    label: title
                }
                if (children) {
                    item.children = this.getArraySelect(children)
                }
                result.push(item)
            })
            return result
        },
        handleSubmit(form) {
            this.$refs[form].validate((pass) => {
                if (pass) {
                    this.loading = !this.loading
                    if (!this.formItem.id) {
                        this.saveMenu(form)
                    } else {
                        this.updateMenu(form)
                    }
                }
            })
        },
        saveMenu(form) {
            this.apiPost('menu', this.formItem).then((res) => {
                const addNode = {
                    title: res.data.title,
                    id: res.data.id,
                    status: res.data.status
                }
                if (this.currentParentData) {
                    let children = this.currentParentData.children || []
                    children.push(addNode)
                    this.$set(this.currentParentData, 'children', children)
                    this.$set(this.currentParentData, 'expand', true)
                } else {
                    this.dataTree.push(addNode)
                }

                this.loading = !this.loading
                this.cancelMinForm()
                this.handleReset(form)

                _g.success(res.message)
            },(res) => {
                this.loading = !this.loading
            })
        },
        updateMenu(form) {
            this.apiPut('menu/', this.formItem.id, this.formItem).then((res) => {
                const parentKey = this.formItem.pid[this.formItem.pid.length - 1]
                const oldParentKey = this.oldEditPid[this.oldEditPid.length - 1]

                if (parentKey === oldParentKey) {
                    this.$set(this.currentParentData, 'title', this.formItem.title)
                    this.$set(
                        this.currentParentData, 'status', this.formItem.status
                        ? 'enable'
                        : 'disable')
                } else {
                    // new parent
                    if (parentKey != -1) {
                        let parent = this.nodeRoot.find(el => el.node.id === parentKey).node
                        let children = parent.children || []
                        children.push(this.currentParentData)
                        this.$set(parent, 'children', children)
                        this.$set(parent, 'expand', true)
                    } else {
                        this.dataTree.push(this.currentParentData)
                    }

                    // old parent
                    if (oldParentKey != -1) {
                        let oldParent = this.nodeRoot.find(el => el.node.id === oldParentKey).node
                        const index = oldParent.children.indexOf(this.currentParentData)
                        oldParent.children.splice(index, 1)
                        this.$set(oldParent, 'children', oldParent.children)
                        this.$set(oldParent, 'expand', false)
                    } else {
                        const index = this.dataTree.indexOf(this.currentParentData)
                        this.dataTree.splice(index, 1)
                    }
                }

                // 清空临时根节点数据，已无用
                this.nodeRoot = []
                this.loading = !this.loading
                this.cancelMinForm()
                this.handleReset(form)

                _g.success(res.message)
            },(res) => {
                this.loading = !this.loading
            })
        },
        handleReset(form) {
            this.$refs[form].resetFields()
        },
        cancelMinForm: function() {
            this.minForm = false
        },
        synchrodataMenu: function(){
            this.loadingSynchrodata = true
            let data = {
                replace: this.synchrodataReplace
            }
            this.apiPost('menu/synchrodata', data).then((res) => {
                _g.success(res.message)
                this.loadingSynchrodata = false
            },(res) => {
                this.loadingSynchrodata = false
            })
        }
    },
    created: function() {
        this.init()
    },
    activated: function() {
        if (_g.needRefresh(this)) {
            this.init()
        }
    },
    mixins: [http]
}
