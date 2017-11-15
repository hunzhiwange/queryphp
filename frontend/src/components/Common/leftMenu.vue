<template>
 <el-menu
    v-bind:collapse="isCollapse"
    v-bind:unique-opened="unique_opened"
    default-active="2"
    class="el-menu-vertical-demo"
    active-text-color="#1d232f">
    <el-submenu v-for="secMenu in menuData" v-bind:index="(secMenu.id.toString())">
      <template slot="title">
        <i v-bind:class="secMenu.menu_icon"></i>
        <span>{{secMenu.title}}</span>
      </template>
      <el-menu-item v-for="item in secMenu.child" v-bind:index="(secMenu.id+'-'+item.id)" @click="routerChange(item)">{{item.title}}</el-menu-item>
    </el-submenu>
  </el-menu>
</template>

<script>
export default {
  props: ['menuData', 'menu', 'isCollapse'],
  data() {
    return {
      unique_opened: true
    }
  },
  methods: {
    routerChange(item) {
      if (item.url != this.$route.path) {
        router.push(item.url)
      } else {
        _g.shallowRefresh(this.$route.name)
      }
    }
  }
}
</script>
