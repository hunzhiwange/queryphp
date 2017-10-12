<template>
  <el-breadcrumb separator="/">
    <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
    <el-breadcrumb-item :to="{ path: '/admin/menu/list' }">菜单管理</el-breadcrumb-item>
    <el-breadcrumb-item>编辑菜单</el-breadcrumb-item>
  </el-breadcrumb>
</template>
<style>
.search-btn {
    position: absolute;
    top: 0px;
    right: 0px;
}
</style>