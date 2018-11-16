import http from "@/utils/http";
import { lock } from "@/utils/auth";

export default {
    name: "lockScreen",
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        lockScreen() {
            this.apiPost("user/lock").then(res => {
                if (res.code == 200) {
                    let lockScreenBack = document.getElementById(
                        "lock_screen_back"
                    );
                    lockScreenBack.style.transition = "all 3s";
                    lockScreenBack.style.zIndex = 10000;
                    lockScreenBack.style.boxShadow =
                        "0 0 0 " + this.lockScreenSize + "px #667aa6 inset";
                    this.showUnlock = true;
                    // 本地存储锁屏之前打开的页面以便解锁后打开
                    lock(this.$route.name);
                    setTimeout(() => {
                        lockScreenBack.style.transition = "all 0s";
                        this.$router.push({
                            name: "locking"
                        });
                    }, 800);
                } else {
                    utils.warning(res.message);
                }
            });
        }
    },
    mounted() {
        let lockdiv = document.createElement("div");
        lockdiv.setAttribute("id", "lock_screen_back");
        lockdiv.setAttribute("class", "lock-screen-back");
        document.body.appendChild(lockdiv);
        let lockScreenBack = document.getElementById("lock_screen_back");
        let x = document.body.clientWidth;
        let y = document.body.clientHeight;
        let r = Math.sqrt(x * x + y * y);
        let size = parseInt(r);
        this.lockScreenSize = size;
        window.addEventListener("resize", () => {
            let x = document.body.clientWidth;
            let y = document.body.clientHeight;
            let r = Math.sqrt(x * x + y * y);
            let size = parseInt(r);
            this.lockScreenSize = size;
            lockScreenBack.style.transition = "all 0s";
            lockScreenBack.style.width = lockScreenBack.style.height =
                size + "px";
        });
        lockScreenBack.style.width = lockScreenBack.style.height = size + "px";
    },
    mixins: [http]
};
