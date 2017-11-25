<template>
<el-dialog title="账号设置" :visible.sync="dialogVisible" width="30%">
    <div>
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
            <el-form-item label="用户昵称" prop="nikename">
                <el-input v-model.trim="form.nikename"></el-input>
            </el-form-item>
            <el-form-item label="邮箱" prop="email">
                <el-input v-model.trim="form.email"></el-input>
            </el-form-item>
            <el-form-item label="手机号" prop="mobile">
                <el-input type="number" v-model.number="form.mobile"></el-input>
            </el-form-item>
        </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" :disabled="disable" @click="submit('form')">确 定</el-button>
        </span>
</el-dialog>
</template>

<script src="./../js/information.js"></script>
<style src="./../css/information.css"></style>
