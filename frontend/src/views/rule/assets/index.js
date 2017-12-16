import http from '@/utils/http'

export default {
    data() {
        var validateAciton = (rule, value, callback) => {
            if (this.formItem.type != 'action') {
                return callback()
            }

            setTimeout(() => {
                if (!value) {
                    callback(new Error(__('请输入菜单方法名称')))
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
                    callback(new Error(__('请输入菜单控制器名称')))
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
                    callback(new Error(__('请输入菜单路由名称')))
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
                    callback(new Error(__('请输入菜单路由路径')))
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
                    callback(new Error(__('请输入菜单路由组件')))
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
                status: true,
                app: 'admin',
                type: 'app',
                value: []
            },
            pidOptions: [],
            oldEditPid: [],
            pidDisabled: true,
            typeDisabled: true,
            currentParentData: null,
            showMenuTree: false,
            minForm: false,
            rules: {
                title: [{
                    required: true,
                    message: __('请输入权限标题')
                }],
                app: [{
                    required: true,
                    message: __('请输入权限应用名称')
                }],
                action: [{
                    validator: validateAciton
                }],
                controller: [{
                    validator: validateController
                }],
                name: [{
                    validator: validateName
                }],
                path: [{
                    validator: validatePath
                }],
                component: [{
                    validator: validateComponent
                }]
            },
            dataTree: [],
            dataMenuTree: [],
            initMenuTree: [],
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
                    <i-button icon='plus-circled' type='default' shape="circle" size='small' style='margin-right: 8px;' on-click={() => this.append(root, node, data)} disabled={data.type == 'rule'
                                    ? true
                                    : false}>{__('子权限')}</i-button>
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
        changeParentId(value, selectedData) {
            let par = selectedData.pop()

            if(!par.type) {
                this.formItem.type = 'app'
            }else if(par.type == 'app') {
                this.formItem.type = 'category'
            }else if(par.type == 'category') {
                this.formItem.type = 'controller'
            }else if(par.type == 'controller') {
                this.formItem.type = 'action'
            }
        },
        edit(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData
            this.nodeRoot = root

            let data = {}
            Object.keys(this.formItem).forEach((item) => {
                if(item == 'pid') {
                    return
                }
                data[item] = nodeData[item]
            })

            data.value = data.value ? data.value.split(',').map(item => parseInt(item)) : []

            data.status = data.status == 'enable'
                ? true
                : false

            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: __('根权限')})
            this.pidOptions = pidOptions

            let parentID = this.getParentID(root, nodeData).reverse()
            parentID.pop()
            if (parentID.length == 0) {
                parentID = [-1]
            }

            setTimeout(() => {
                this.pidDisabled = false
                this.oldEditPid = data.pid = parentID
                this.formItem = data

                if(data.type == 'rule') {
                    this.showMenuTree = true
                }else {
                    this.showMenuTree = false
                }
                this.dataMenuTree = this.setMenuCheckedNodes(this.initMenuTree, data.value)
            }, 0)
        },
        setMenuCheckedNodes(menuTree, value) {
            if(!value) {
                return []
            }

            let result = []

            menuTree.forEach((el,index) => {
                let item = {
                    title: el.title,
                    id: el.id
                }
                if(value.includes(el.id)) {
                    item.checked = true
                }

                if(el.children) {
                    item.children = this.setMenuCheckedNodes(el.children, value)
                }else{
                    item.children = []
                }
                result[index] = item
            })

            return result
        },
        append(root, node, nodeData) {
            this.minForm = true
            this.currentParentData = nodeData
            this.formItem.id = ''
            this.showMenuTree = false

            let pidOptions = this.getArraySelect(this.dataTree)
            pidOptions.unshift({value: -1, label: __('根权限')})
            this.pidOptions = pidOptions
            let parentID = this.getParentID(root, nodeData).reverse()
            setTimeout(() => {
                this.formItem.pid = parentID
                this.formItem.app = nodeData.app

                if(nodeData.type == 'app') {
                    this.formItem.type = 'category'
                }else if(nodeData.type == 'category') {
                    this.formItem.type = 'rule'
                    this.showMenuTree = true
                }
                this.dataMenuTree = this.initMenuTree
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
            this.formItem.id = ''

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
            // this.apiGet('rule').then((res) => {
            //     this.dataTree = res.data
            // })

            // this.apiGet('rule/menu').then((res) => {
            //     this.dataMenuTree = res.data
            // })

            this.apiMulti('get','rule')
            .then((res) => {
                this.dataTree = res.data
             })
            .apiMulti('get','rule/menu')
            .then((res) => {
                this.initMenuTree = res.data
             })
            .apiMulti('rule/index_menu')
            .then((res) => {
                this.thenCalback(res)
            },(res) => {
               // error
            })
        },
        getArraySelect(data) {
            let result = []

            data.forEach(({id, title, type, children}) => {
                if(type == 'rule'){
                    return
                }

                let item = {
                    value: id,
                    label: title,
                    type: type
                }
                if (children) {
                    item.children = this.getArraySelect(children)
                }
                result.push(item)
            })
            return result
        },
        handleSubmit(form) {
            this.formItem.value = []
            let selected = this.$refs.menuTree.getCheckedNodes()
            selected.forEach(({id}) => this.formItem.value.push(id))

            if(this.formItem.controller && ['category', 'controller'].includes(this.formItem.type)) {
                if(!this.formItem.name) {
                   this.formItem.name = this.formItem.controller
                }

                if(!this.formItem.path) {
                   this.formItem.path = this.formItem.controller
                }
            }

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
            this.apiPost('rule', this.formItem).then((res) => {
                const addNode = {
                    title: res.data.title,
                    id: res.data.id,
                    pid: res.data.pid,
                    name: res.data.name,
                    status: res.data.status,
                    sort: res.data.sort,
                    app: res.data.app,
                    type: res.data.type
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
                this.cancelMinForm(form)

                _g.success(res.message)
            },(res) => {
                this.loading = !this.loading
            })
        },
        handleReset(form) {
            this.$refs[form].resetFields()
        },
        cancelMinForm: function(form) {
            this.minForm = false
            this.handleReset(form)
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
    computed: {
        showAction: function () {
            return this.formItem.type === 'action'
        },
        showController: function () {
            return this.formItem.type !== 'app'
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
