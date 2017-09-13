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
      :data="data2"  
      :props="defaultProps"  
      show-checkbox  
      node-key="id"  
      default-expand-all  
      :filter-node-method="filterNode"
      :expand-on-click-node="false"  
      :render-content="renderContent">  
    </el-tree>

    </div>
</template>

<script>
  let id = 1000
  export default {
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
            },
            {
              id: 10,
              label: '三级 1-1-2'
            }]
          }]
        },
        {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          },
          {
            id: 6,
            label: '二级 2-2'
          }]
        },
        {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          },
          {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    },

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
      append: function(store, data) {
        store.append({ id: id++, label: 'testtest', children: [] }, data)
      },
      remove: function(store, data) {
        store.remove(data)
      },
      renderContent: function(createElement, { node, data, store }) {
        var self = this
        return createElement('span', [
          createElement('span', node.label),
          createElement('span', { attrs: {
            style: 'float: right; margin-right: 20px'
          }}, [
            createElement('el-button', { attrs: {
              size: 'mini'
            }, on: {
              click: function() {
                console.info('点击了节点' + data.id + '的添加按钮')
                store.append({ id: self.baseId++, label: 'testtest', children: [] }, data)
              }
            }}, '添加'),
            createElement('el-button', { attrs: {
              size: 'mini'
            }, on: {
              click: function() {
                console.info('点击了节点' + data.id + '的删除按钮')
                store.remove(data)
              }
            }}, '删除')
          ])
        ])
      }
    }
  }
</script>