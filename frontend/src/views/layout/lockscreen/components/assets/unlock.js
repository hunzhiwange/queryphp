import http from "@/utils/http";
import { unlock } from "@/utils/auth";

export default {
    name: "Unlock",
    data() {
        return {
            avatorLeft: "0px",
            inputLeft: "400px",
            password: "",
            check: null
        };
    },
    props: {
        showUnlock: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        avatorPath() {
            return localStorage.avatorImgPath;
        }
    },
    methods: {
        handleClickAvator() {
            this.avatorLeft = "-180px";
            this.inputLeft = "0px";
            this.$refs.inputEle.focus();
        },
        handleUnlock() {
            if (!this.password) {
                utils.warning(__("请输入密码"));
                return;
            }

            let data = {
                password: this.password
            };
            this.apiPost("user/unlock", data).then(res => {
                if (res.code == 200) {
                    this.avatorLeft = "0px";
                    this.inputLeft = "400px";
                    this.password = "";
                    unlock();
                    this.$emit("on-unlock");
                } else {
                    utils.warning(res.message);
                }
            });
        },
        unlockMousedown() {
            this.$refs.unlockBtn.className = "unlock-btn click-unlock-btn";
        },
        unlockMouseup() {
            this.$refs.unlockBtn.className = "unlock-btn";
        }
    },
    mixins: [http]
};
