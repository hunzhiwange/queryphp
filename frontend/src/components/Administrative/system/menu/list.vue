<template>
    <div>
      <el-row :gutter="20">
        <el-col :span="16">
          <div class="m-b-20">
            <breadcrumb ref="breadcrumb"></breadcrumb>
          </div>
        </el-col>
        <el-col :span="8">
          <router-link class="el-button el-button--success is-plain el-button--small pull-right" to="add">
            <i class="el-icon-plus"></i>&nbsp;&nbsp;添加菜单
          </router-link>
        </el-col>
      </el-row>

      <div class="m-b-5">
        <el-input
          placeholder="试试搜索"
          v-model="filterText">
        </el-input>
      </div>

      <el-tree
        class="filter-tree"
        :data="data2"
        :props="defaultProps"
        :filter-node-method="filterNode"
        ref="tree2"
        node-key="id"
        accordion2
        show-checkbox
        :render-content="renderContent">
      </el-tree>

      <div class="pos-rel p-t-20">
        <btnGroup :selectedData="multipleSelection" :type="'menus'"></btnGroup>
      </div>
    </div>
</template>

<script>
  import btnGroup from '../../../Common/btn-group.vue'
  import breadcrumb from './breadcrumb_list.vue'
  import http from '../../../../assets/js/http'

  export default {
    watch: {
      filterText(val) {
        this.$refs.tree2.filter(val)
      }
    },

    methods: {
      filterNode(value, data) {
        if (!value) return true
        return data.label.indexOf(value) !== -1
      },
      append(store, data) {
        store.append({ id: id++, label: 'testtest', children: [] }, data)
      },
      child(store, data, event) {
        window.event ? window.event.cancelBubble = true : event.stopPropagation()
        router.replace('/admin/menu/add/' + data.id)
      },
      edit(store, data, event) {
        window.event ? window.event.cancelBubble = true : event.stopPropagation()
        router.replace('/admin/menu/edit/' + data.id)
      },
      top(store, data, event) {
        window.event ? window.event.cancelBubble = true : event.stopPropagation()
        _g.openGlobalLoading()
        this.apiPut('admin/menus/top', item.id).then((res) => {
          _g.closeGlobalLoading()
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', res.message)
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1000)
          })
        })
      },
      remove(store, data, event) {
        // store.remove(data)
       // console.log(store, data)
       // console.log(data.id)
        // console.log(event)
        this.open2(data)
        window.event ? window.event.cancelBubble = true : event.stopPropagation()
      },
      open2(item) {
        this.$confirm('确认删除该菜单?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          _g.openGlobalLoading()
          this.apiDelete('admin/menus/', item.id).then((res) => {
            _g.closeGlobalLoading()
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', res.message)
              setTimeout(() => {
                _g.shallowRefresh(this.$route.name)
              }, 1000)
            })
          })
        }).catch(() => {
        })
      },
      renderContent(h, { node, data, store }) {
        return (
          <span>
            <span class='el-tree-node__label'>
              <span>{node.label}</span>
            </span>
            <span style='float: right; margin-right: 20px'>
              <el-button size='mini' icon='plus' on-click={ () => this.child(store, data, event) }>添加子菜单</el-button>
              <el-button size='mini' icon='edit' on-click={ () => this.edit(store, data, event) }>修改</el-button>
              <el-button size='mini' icon='star-on' on-click={ () => this.top(store, data, event) }>置顶</el-button>
              <el-button size='mini' icon='delete' on-click={ () => this.remove(store, data, event) }>删除</el-button>
            </span>
          </span>)
      }
    },

    data() {
      return {
        filterText: '',
        data2: [],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    },
    created() {
      this.apiGet('admin/menus').then((res) => {
        this.handelResponse(res, (data) => {
          this.data2 = data
        })
      })
    },
    components: {
      breadcrumb, btnGroup
    },
    mixins: [http]
  }
</script>