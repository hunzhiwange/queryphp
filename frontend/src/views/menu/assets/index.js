import http from '@/utils/http'
import {validateAlphaDash} from '@/utils/validate'

export default {
    data() {
        var validateAciton = (rule, value, callback) => {
            if (this.formItem.type != 'action') {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入菜单方法名称')))
                } else {
                    return callback()
                }
            }, 50)
        }

        var validateController = (rule, value, callback) => {
            if (this.formItem.type == 'app') {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入菜单控制器名称')))
                } else {
                    return callback()
                }
            }, 50)
        }

        var validateName = (rule, value, callback) => {
            if (!['category', 'controller'].includes(this.formItem.type)) {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入菜单路由名称')))
                } else {
                    return callback()
                }
            }, 50)
        }

        var validatePath = (rule, value, callback) => {
            if (!['category', 'controller'].includes(this.formItem.type)) {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入菜单路由路径')))
                } else {
                    return callback()
                }
            }, 50)
        }

        var validateComponent = (rule, value, callback) => {
            if (!['category', 'controller'].includes(this.formItem.type)) {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(this.__('请输入菜单路由组件')))
                } else {
                    return callback()
                }
            }, 50)
        }

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
                app: 'admin',
                controller: '',
                action: '',
                type: 'app',
                siblings: '',
                rule: 'T',
            },
            siblings: [],
            siblingsList: [],
            pidOptions: [],
            oldEditPid: [],
            pidDisabled: true,
            typeDisabled: true,
            currentParentData: null,
            minForm: false,
            rules: {
                title: [
                    {
                        required: true,
                        message: this.__('请输入菜单标题'),
                    },
                ],
                app: [
                    {
                        required: true,
                        message: this.__('请输入菜单应用名称'),
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
                action: [
                    {
                        validator: validateAciton,
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
                controller: [
                    {
                        validator: validateController,
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
                name: [
                    {
                        validator: validateName,
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
                path: [
                    {
                        validator: validatePath,
                    },
                ],
                component: [
                    {
                        validator: validateComponent,
                    },
                    {
                        validator: validateAlphaDash,
                    },
                ],
            },
            dataTree: [],
            loading: false,
            nodeRoot: [],
            loadingSynchrodata: false,
            synchrodataReplace: false,
        }
    },
    methods: {
        renderContent(h, {root, node, data}) {
            const status = data.status == 'enable'
            return (
                <span class="tree-item" style="display: inline-block; width: 100%;">
                    <span
                        class="tree-item-title"
                        style={{
                            textDecoration: data.rule == 'T' ? 'none' : 'line-through',
                        }}>
                        {data.title}
                    </span>
                    <span class="tree-item-operate" style="display: inline-block;float: right;margin-right: 32px;">
                        <i-button
                            icon="plus-circled"
                            type="default"
                            shape="circle"
                            size="small"
                            style="margin-right: 8px;"
                            on-click={() => this.append(root, node, data)}
                            disabled={data.type == 'action' ? true : false}>
                            {__('子菜单')}
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
                            on-click={() => this.status(data, status ? 'disable' : 'enable')}>
                            {status ? __('禁用') : __('启用')}
                        </i-button>
                        <dropdown on-on-click={name => this[name](root, node, data)} placement="bottom-end">
                            <i-button icon="more" type="default" shape="circle" size="small" />
                            <dropdownMenu slot="list">
                                <dropdownItem name="top">
                                    <icon type="android-arrow-dropup-circle" /> {__('置顶')}
                                </dropdownItem>
                                <dropdownItem name="up">
                                    <icon type="arrow-up-a" />
                                    {__('上移')}
                                </dropdownItem>
                                <dropdownItem name="down">
                                    <icon type="arrow-down-a" />
                                    {__('下移')}
                                </dropdownItem>
                                <dropdownItem name="remove" disabled={data.children && data.children.length > 0 ? true : false}>
                                    <icon type="trash-b" /> {__('删除')}
                                </dropdownItem>
                            </dropdownMenu>
                        </dropdown>
                    </span>
                </span>
            )
        },
        changeParentId(value, selectedData) {
            let par = selectedData.pop()

            if (!par.type) {
                this.formItem.type = 'app'
            } else if (par.type == 'app') {
                this.formItem.type = 'category'
            } else if (par.type == 'category') {
                this.formItem.type = 'controller'
            } else if (par.type == 'controller') {
                this.formItem.type = 'action'
            }
        },
        edit(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData
            this.formItem.id = nodeData.id
            this.nodeRoot = root

            let data = {}
            Object.keys(this.formItem).forEach(item => {
                if (item == 'pid') {
                    return
                }
                data[item] = nodeData[item]
            })
            data.status = data.status == 'enable' ? true : false
            this.formItem = data

            let pidOptions = this.getArraySelect(this.dataTree, true)
            pidOptions.unshift({value: -1, label: this.__('根菜单')})
            this.pidOptions = pidOptions
            let parentID = this.getParentID(root, nodeData).reverse()
            parentID.pop()
            if (parentID.length == 0) {
                parentID = [-1]
            }

            if (data.type == 'action') {
                const parentKey = node.parent
                if (parentKey !== undefined) {
                    const parent = root.find(el => el.nodeKey === parentKey).node
                    let siblingsList = []
                    if (parent.children) {
                        parent.children.forEach(item => {
                            if (item.id != nodeData.id) {
                                siblingsList.push({
                                    id: item.id,
                                    title: item.title,
                                })
                            }
                        })
                    }
                    this.$set(this, 'siblingsList', siblingsList)
                }

                this.siblings = this.formItem.siblings ? this.formItem.siblings.split(',').map(item => parseInt(item)) : []
            } else {
                this.$set(this, 'siblingsList', [])
                this.siblings = []
            }

            setTimeout(() => {
                this.pidDisabled = false
                this.oldEditPid = this.formItem.pid = parentID
            }, 0)
        },
        append(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData
            this.formItem.id = ''
            this.pidDisabled = true

            // 父级菜单
            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: __('根菜单')})
            this.pidOptions = pidOptions
            let parentID = this.getParentID(root, nodeData).reverse()

            setTimeout(() => {
                this.formItem.pid = parentID
                this.formItem.app = nodeData.app

                if (nodeData.type == 'app') {
                    this.formItem.type = 'category'
                    this.formItem.component = 'layout'
                } else if (nodeData.type == 'category') {
                    this.formItem.type = 'controller'
                    this.formItem.component = 'layout'
                } else if (nodeData.type == 'controller') {
                    this.formItem.type = 'action'
                    this.formItem.controller = nodeData.controller
                }

                // 兄弟菜单
                if (this.formItem.type == 'action') {
                    let siblingsList = []
                    if (nodeData.children) {
                        nodeData.children.forEach(item => {
                            siblingsList.push({
                                id: item.id,
                                title: item.title,
                            })
                        })
                    }
                    this.$set(this, 'siblingsList', siblingsList)
                } else {
                    this.$set(this, 'siblingsList', [])
                }

                this.siblings = []
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
        add: function() {
            this.minForm = true
            this.currentParentData = null
            this.formItem.id = ''
            this.pidDisabled = true

            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: this.__('根菜单')})
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
                title: this.__('提示'),
                content: this.__('确认删除该菜单?'),
                onOk: () => {
                    this.apiDelete('menu', nodeData.id).then(res => {
                        utils.success(res.message)

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
                onCancel: () => {},
            })
        },
        status(nodeData, status) {
            this.apiPut('menu/enable/', nodeData.id, {status: status}).then(res => {
                this.$set(nodeData, 'status', status)
                utils.success(res.message)
            })
        },
        statusMany(type) {
            let selected = this.$refs.tree.getCheckedNodes()
            if (!selected.length) {
                utils.warning(this.__('请勾选数据'))
                return
            }

            let selectedIds = []
            selected.forEach(({id}) => selectedIds.push(id))

            let data = {
                ids: selectedIds,
                status: type,
            }

            this.apiPost('menu/enables', data).then(res => {
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

            this.apiPut('menu/order/', nodeData.id, {type: type}).then(res => {
                utils.success(res.message)

                if (parentKey !== undefined) {
                    switch (type) {
                        case 'up':
                            parent.children = this.swapItems(parent.children, index, index - 1)
                            break
                        case 'down':
                            parent.children = this.swapItems(parent.children, index, index + 1)
                            break
                        case 'top':
                            parent.children = this.swapItems(parent.children, index, 0)
                            break
                    }
                } else {
                    switch (type) {
                        case 'up':
                            this.dataTree = this.swapItems(this.dataTree, index, index - 1)
                            break
                        case 'down':
                            this.dataTree = this.swapItems(this.dataTree, index, index + 1)
                            break
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
            this.apiGet('menu').then(res => {
                this.dataTree = res
            })
        },
        getArraySelect(data, isEdit) {
            let result = []

            data.forEach(({id, title, type, children}) => {
                if (type == 'action') {
                    return
                }

                if (isEdit && id == this.formItem.id) {
                    return
                }

                let item = {
                    value: id,
                    label: title,
                    type: type,
                }
                if (children) {
                    item.children = this.getArraySelect(children, isEdit)
                }
                result.push(item)
            })
            return result
        },
        handleSubmit(form) {
            if (this.formItem.controller && ['category', 'controller'].includes(this.formItem.type)) {
                if (!this.formItem.name) {
                    this.formItem.name = this.formItem.controller
                }

                if (!this.formItem.path) {
                    this.formItem.path = this.formItem.controller
                }
            }

            if (this.formItem.type == 'action') {
                this.formItem.siblings = this.siblings ? this.siblings.join(',') : ''
            } else {
                this.formItem.siblings = ''
            }

            this.$refs[form].validate(pass => {
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
            this.apiPost('menu', this.formItem).then(
                res => {
                    const addNode = {
                        title: res.data.title,
                        id: res.data.id,
                        status: res.data.status,
                        app: res.data.app,
                        controller: res.data.controller,
                        action: res.data.action,
                        type: res.data.type,
                        rule: res.data.rule,
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
                    this.cancelMinForm(form)

                    utils.success(res.message)
                },
                res => {
                    this.loading = !this.loading
                }
            )
        },
        updateMenu(form) {
            this.apiPut('menu', this.formItem.id, this.formItem).then(
                res => {
                    const parentKey = this.formItem.pid[this.formItem.pid.length - 1]
                    const oldParentKey = this.oldEditPid[this.oldEditPid.length - 1]

                    if (parentKey === oldParentKey) {
                        this.$set(this.currentParentData, 'title', this.formItem.title)
                        this.$set(this.currentParentData, 'status', this.formItem.status ? 'enable' : 'disable')
                        this.$set(this.currentParentData, 'rule', this.formItem.rule)
                    } else {
                        // new parent
                        if (parentKey != -1) {
                            let parent = this.nodeRoot.find(el => el.node.id === parentKey).node
                            let children = parent.children || []
                            children.push(this.currentParentData)
                            this.$set(parent, 'children', children)
                            this.$set(parent, 'expand', true)

                            if (parent.type == 'app') {
                                this.formItem.type = 'category'
                                this.formItem.component = 'layout'
                            } else if (parent.type == 'category') {
                                this.formItem.type = 'controller'
                                this.formItem.component = 'layout'
                            } else if (parent.type == 'controller') {
                                this.formItem.type = 'action'
                                this.formItem.controller = parent.controller
                            }
                        } else {
                            this.$set(this.currentParentData, 'type', 'app')
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
        synchrodataMenu: function() {
            this.loadingSynchrodata = true
            let data = {
                replace: this.synchrodataReplace,
            }
            this.apiPost('menu/synchrodata', data).then(
                res => {
                    utils.success(res.message)
                    this.loadingSynchrodata = false
                },
                res => {
                    this.loadingSynchrodata = false
                }
            )
        },
    },
    computed: {
        showAction: function() {
            return this.formItem.type === 'action'
        },
        showController: function() {
            return this.formItem.type !== 'app'
        },
        showSiblings: function() {
            return this.formItem.type === 'action'
        },
        showRule: function() {
            return this.formItem.type === 'action'
        },
    },
    created: function() {
        this.init()
    },
    activated: function() {
        if (utils.needRefresh(this)) {
            this.init()
        }
    },
    mixins: [http],
}
