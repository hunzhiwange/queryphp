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
      :expand-on-click-node="false"
      :render-content2222="renderContent">
    </el-tree>

    </div>
</template>

<script>
  let id = 1000

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
      remove(store, data) {
        // store.remove(data)
        console.log(store, data)
        console.log(data.id)
        this.open2()
      },
      open2() {
        this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$message({
            type: 'success',
            message: '删除成功!'
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          })
        })
      },
      renderContent(h, { node, data, store }) {
        return (
          <span>
            <span>
              <span>{node.label}</span>
            </span>
            <span style='float: right; margin-right: 20px'>
              <el-button size='mini' on-click={ () => this.append(store, data) }>Append</el-button>
              <el-button size='mini' on-click={ () => this.remove(store, data) }>Delete</el-button>
            </span>
          </span>)
      }
    },

    data() {
      return {
        filterText: '',
        data2: [{
          id: 1,
          label: '一级 1',
          children: [{
            id: 4,
            label: '二级 1-1',
            children: [{
              id: 9,
              label: '三级 1-1-1'
            }, {
              id: 10,
              label: '三级 1-1-2'
            }]
          }]
        }, {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          }, {
            id: 6,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    }
  }
</script>