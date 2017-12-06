<template>
<div class="dashboard-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>新增菜单</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110">
                        <FormItem label="标题" prop="title">
                            <Input v-model.trim="formItem.title" placeholder=""></Input>
                        </FormItem>
                        <FormItem label="上级菜单" prop="pid">
                            <Cascader v-model="formItem.pid" :data="pidOptions" :disabled="pidDisabled" filterable change-on-select></Cascader>
                        </FormItem>
                        <FormItem label="菜单类型" prop="menu_type">
                            <RadioGroup v-model="formItem.menu_type">
                                <Radio label="1">普通三级菜单</Radio>
                                <Radio label="2">单页菜单</Radio>
                                <Radio label="3">外链</Radio>
                            </RadioGroup>
                        </FormItem>
                        <FormItem label="路径" prop="url">
                            <Input v-model.trim="formItem.url" placeholder=""></Input>
                        </FormItem>
                        <FormItem label="模块" prop="module">
                            <Input v-model.trim="formItem.module" placeholder=""></Input>
                        </FormItem>
                        <FormItem label="所属菜单" prop="menu">
                            <Input v-model.trim="formItem.menu" placeholder=""></Input>
                        </FormItem>
                        <FormItem label="图标" prop="menu_icon">
                            <Input v-model.trim="formItem.menu_icon" placeholder=""></Input>
                        </FormItem>
                        <FormItem label="状态">
                            <i-switch v-model="formItem.status" size="large">
                                <span slot="open">启用</span>
                                <span slot="close">禁用</span>
                            </i-switch>
                        </FormItem>
                    </Form>
                </div>
                <div class="min-form-footer">
                    <Button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">确定</Button>
                    <Button type="ghost" style="margin-left: 8px;" @click="cancelMinForm">取消</Button>
                </div>
            </div>
        </div>

        <Card>
            <p slot="title">
                菜单管理
            </p>
            <Button slot="extra" type="primary" @click="addMenu()"><Icon type="android-add-circle"></Icon> 新增</Button>
            <div>
                <Row>
                    <Col span="24">
                    <Tree :data="dataTree" ref="tree" show-checkbox multiple :render="renderContent"></Tree>
                    </Col>
                </Row>
            </div>
        </Card>
    </Row>

    <Row class="m-t-10">
        <ButtonGroup shape="circle">
            <Button type="primary" icon="eye" @click="statusMany('enable')">启用</Button>
            <Button type="primary" icon="eye-disabled" @click="statusMany('disable')">禁用</Button>
        </ButtonGroup>
    </Row>
</div>
</template>

<script src="./assets/index.js"></script>
<style src="./assets/index.css"></style>
