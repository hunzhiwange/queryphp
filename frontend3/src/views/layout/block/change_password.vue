<template>
<el-dialog ref="dialog" :visible.sync="dialogVisible" width="30%" title="修改密码">
    <div class="ovf-auto">
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
            <el-form-item label="旧密码" prop="old_pwd">
                <el-input type="password" v-model.trim="form.old_pwd" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="新密码" prop="new_pwd">
                <el-input type="password" v-model.trim="form.new_pwd" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="confirm_pwd">
                <el-input type="password" v-model.trim="form.confirm_pwd" auto-complete="off"></el-input>
            </el-form-item>
        </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" :disabled="disable" @click="submit('form')">确 定</el-button>
    </span>
</el-dialog>
</template>

<script src="./../js/change_password.js"></script>
<style src="./../css/change_password.css"></style>
