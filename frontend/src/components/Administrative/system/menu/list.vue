<template>
  <div>
    <el-row :gutter="20">
      <el-col :span="16">
        <div class="m-b-20">
          <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item>菜单管理</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
      </el-col>
      <el-col :span="8">
         <router-link :to="{path: '/admin/menu/add'}">
          <el-button class="pull-right" type="primary" size="mini" plain round><i class="el-icon-plus"></i>&nbsp;添加菜单</el-button>
         </router-link>
      </el-col>
    </el-row>

    <div class="m-b-5">
      <el-input
        placeholder="试试过滤"
        v-model="filterText">
      </el-input>
    </div>

    <el-tree
      class="filter-tree"
      :data="dataTree"
      :props="defaultProps"
      :filter-node-method="filterNode"
      ref="tree"
      node-key="id"
      show-checkbox
      default-expand-all
      highlight-current
      :render-content="renderContent">
    </el-tree>
    <div class="pos-rel p-t-20">
      <el-button size="mini" @click="enables('enable')">启用</el-button>
      <el-button size="mini"type="danger" plain @click="enables('disable')">禁用</el-button>
    </div>
  </div>
</template>

<script>
import http from '../../../../assets/js/http'

export default {
  methods: {
    child(node, data, store, event) {
      this.stopPropagation(event)
      router.replace('/admin/menu/add/' + data.id)
    },
    edit(node, data, store, event) {
      this.stopPropagation(event)
      router.replace('/admin/menu/edit/' + data.id)
    },
    top(node, data, store, event) {
      this.order(node, data, store, event, 'top')
    },
    up(node, data, store, event) {
      this.order(node, data, store, event, 'up')
    },
    down(node, data, store, event) {
      this.order(node, data, store, 'down')
    },
    enable(node, data, store, event, status) {
      this.stopPropagation(event)
      this.apiPut('/admin/menu/enable/', data.id, { status: status }).then((res) => {
        this.handelResponse(res, (data) => {
          _g.toastMsg('success', res.message)
          setTimeout(() => {
            _g.shallowRefresh(this.$route.name)
          }, 1000)
        })
      })
    },
    remove(node, data, store, event) {
      this.stopPropagation(event)
      if (node.childNodes.length) return
      this.$confirm('确认删除该菜单?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.apiDelete('/admin/menu/', data.id).then((res) => {
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
    enables(type) {
      let selectedIds = this.$refs.tree.getCheckedKeys()
      if (!selectedIds.length) {
        _g.toastMsg('warning', '请勾选数据')
        return
      }

      let data = {
        ids: selectedIds,
        status: type
      }

      this.apiPost('/admin/menu/enables', data).then((res) => {
        this.handelResponse(res, (data) => {
          _g.toastMsg('success', res.message)
          setTimeout(() => {
            _g.shallowRefresh(this.$route.name)
          }, 1500)
        })
      })
    },
    filterNode(value, data) {
      if (!value) return true
      return data.label.indexOf(value) !== -1
    },
    order(node, data, store, event, type) {
      this.stopPropagation(event)
      this.apiPut('/admin/menu/order/', data.id, { type: type }).then((res) => {
        this.handelResponse(res, (data) => {
          _g.toastMsg('success', res.message)
          setTimeout(() => {
            _g.shallowRefresh(this.$route.name)
          }, 1000)
        })
      })
    },
    stopPropagation(event) {
      window.event ? window.event.cancelBubble = true : event.stopPropagation()
    },
    renderContent(h, { node, data, store }) {
      return (
        <span style='flex: 1; display: flex; align-items: center; justify-content: space-between; font-size: 14px; padding-right: 8px;'>
          <span>
            <span>{node.label}</span>
          </span>
          <span>
            <el-button type='text' style='font-size: 12px;' on-click={ () => this.enable(node, data, store, event, this.status[data.id] == 'enable' ? 'diable' : 'enable') } domPropsInnerHTML={this.status[data.id] == 'enable' ? '<span style="color:#67C23A;" class="el-icon-circle-check"> 已启用</span>' : '<span style="color:#EB9E05;" class="el-icon-circle-close"> 已禁用</span>'}></el-button>
            <el-button type='text' style='font-size: 12px;' icon='el-icon-plus' on-click={ () => this.child(store, data, event) }>子菜单</el-button>
            <el-button type='text' style='font-size: 12px;' icon='el-icon-edit' on-click={ () => this.edit(node, data, store, event) }>修改</el-button>
            <el-button type='text' style='font-size: 12px;' icon='el-icon-star-on' on-click={ () => this.top(node, data, store, event) }>置顶</el-button>
            <el-button type='text' style='font-size: 12px;' icon='fa fa fa-arrow-up' on-click={ () => this.up(node, data, store, event) }>上移</el-button>
            <el-button type='text' style='font-size: 12px;' icon='fa fa fa-arrow-down' on-click={ () => this.down(node, data, store, event) }>下移</el-button>
            <el-button type='text' style='font-size: 12px;' icon={node.childNodes.length ? 'el-icon-warning' : 'el-icon-delete'} on-click={ () => this.remove(node, data, store, event) } ref={{ disabled: true }}>{node.childNodes.length ? '禁止' : '删除'}</el-button>
          </span>
        </span>)
    }
  },

  data() {
    return {
      filterText: '',
      dataTree: [],
      status: [],
      defaultProps: {
        children: 'children',
        label: 'label'
      }
    }
  },
  created() {
    this.apiGet('/admin/menu').then((res) => {
      this.handelResponse(res, (data) => {
        this.dataTree = data.menu
        this.status = data.status
      })
    })
  },
  watch: {
    filterText(val) {
      this.$refs.tree.filter(val)
    }
  },
  components: {},
  mixins: [http]
}
</script>