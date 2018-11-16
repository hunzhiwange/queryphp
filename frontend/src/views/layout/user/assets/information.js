import http from "@/utils/http";
import { validateChineseAlphaDash, validateMobile } from "@/utils/validate";

export default {
    data() {
        return {
            dialogVisible: false,
            loading: false,
            form: {
                nikename: "",
                email: "",
                mobile: ""
            },
            rules: {
                nikename: [
                    {
                        required: true,
                        validator: validateChineseAlphaDash
                    }
                ],
                email: [
                    {
                        type: "email",
                        required: true,
                        message: __("请输入有效的邮箱")
                    }
                ],
                mobile: [
                    {
                        type: "number",
                        validator: validateMobile,
                        required: true,
                        message: __("请输入有效的手机号")
                    }
                ]
            }
        };
    },
    methods: {
        open() {
            this.dialogVisible = true;
        },
        ok() {
            this.$refs.form.validate(pass => {
                if (pass) {
                    this.loading = true;
                    this.apiPost("user/update_info", this.form).then(
                        res => {
                            utils.success(res.message);

                            let users = this.$store.state.user.users;
                            users.nikename = this.form.nikename;
                            users.email = this.form.email;
                            users.mobile = this.form.mobile;

                            this.$store.dispatch("setUsers", users);

                            setTimeout(() => {
                                this.loading = !this.loading;
                                this.cancel();
                            }, 1000);
                        },
                        res => {
                            this.loading = !this.loading;
                        }
                    );
                }
            });
        },
        cancel() {
            this.dialogVisible = false;
        }
    },
    created() {
        let users = this.$store.state.user.users;
        this.form.nikename = users.nikename;
        this.form.email = users.email;
        this.form.mobile = users.mobile;
    },
    mixins: [http]
};
