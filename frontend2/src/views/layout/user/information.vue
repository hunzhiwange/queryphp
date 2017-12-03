<template>
<Modal v-model="dialogVisible" title="账号设置" width="500" >
    <div>
        <Form ref="form" :model="form" :rules="rules" :label-width="80">
            <FormItem label="用户昵称" prop="nikename">
                <Input v-model.trim="form.nikename" placeholder=""></Input>
            </FormItem>
            <FormItem label="邮箱" prop="email">
                <Input v-model.trim="form.email" placeholder=""></Input>
            </FormItem>
            <FormItem label="手机号" prop="mobile">
                <Input v-model.number="form.mobile" placeholder=""></Input>
            </FormItem>
        </Form>
    </div>
    <div slot="footer">
        <Button type="text" @click="cancel">取消</Button>
        <Button type="primary" :loading="loading" @click="ok">确认</Button>
    </div>
</Modal>
</template>

<script src="./assets/information.js"></script>
