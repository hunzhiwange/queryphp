<template>
    <div>
        <div class="m-b-20">
        <router-link class="btn-link-large add-btn" to="add">
          <i class="el-icon-plus"></i>&nbsp;&nbsp;添加菜单
        </router-link>
        </div>

    <el-input
      placeholder="输入关键字进行过滤"
      v-model="filterText">
    </el-input>

    <el-tree
      class="filter-tree"
      :data="data2"
      :props="defaultProps"
      default-expand-all
      :filter-node-method="filterNode"
      ref="tree2"
      node-key="id"
      accordion
      :render-content="renderContent">
    </el-tree>

    </div>
</template>

<script>
  let id = 1000

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
              <el-button size='mini' icon='plus' on-click={ () => this.append(store, data, event) }>添加子菜单</el-button>
              <el-button size='mini' icon='edit' on-click={ () => this.remove(store, data, event) }>修改</el-button>
              <el-button size='mini' icon='star-on' on-click={ () => this.append(store, data, event) }>置顶</el-button>
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
    mixins: [http]
  }
</script>