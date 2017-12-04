<template>
    <Modal v-model="dialogVisible" :title="__('修改密码')" width="500" >
        <div>
            <Form ref="form" :model="form" :rules="rules" :label-width="80">
                <FormItem :label="__('旧密码')" prop="old_pwd">
                    <Input type="password" v-model.trim="form.old_pwd" placeholder="" auto-complete="off"></Input>
                </FormItem>
                <FormItem :label="__('新密码')" prop="new_pwd">
                    <Input type="password" v-model.trim="form.new_pwd" placeholder="" auto-complete="off"></Input>
                </FormItem>
                <FormItem :label="__('确认密码')" prop="confirm_pwd">
                    <Input type="password" v-model.trim="form.confirm_pwd" placeholder="" auto-complete="off"></Input>
                </FormItem>
            </Form>
        </div>
        <div slot="footer">
            <Button type="text" @click="cancel">{{__('取消')}}</Button>
            <Button type="error" :loading="loading" @click="ok">{{__('确认')}}</Button>
        </div>
    </Modal>
</template>

<script src="./assets/change_password.js"></script>
