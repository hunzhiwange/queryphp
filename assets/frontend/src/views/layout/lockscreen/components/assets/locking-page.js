import unlock from './../unlock.vue'
import {lockLastPage} from '@/utils/auth'

export default {
    components: {
        unlock,
    },
    data() {
        return {
            showUnlock: false,
        }
    },
    methods: {
        handleUnlock() {
            let lockScreenBack = document.getElementById('lock_screen_back')
            this.showUnlock = false
            lockScreenBack.style.zIndex = -1
            lockScreenBack.style.boxShadow = '0 0 0 0 #667aa6 inset'
            this.$router.push({
                name: lockLastPage(), // 解锁之后跳转到锁屏之前的页面
            })
        },
    },
    mounted() {
        this.showUnlock = true
        if (!document.getElementById('lock_screen_back')) {
            let lockdiv = document.createElement('div')
            lockdiv.setAttribute('id', 'lock_screen_back')
            lockdiv.setAttribute('class', 'lock-screen-back')
            document.body.appendChild(lockdiv)
            let x = window.screen.height
            let y = window.screen.width
            let r = Math.sqrt(x * x + y * y)
            let size = parseInt(r)
            document.body.style.height = size + 'px'
        }
        let lockScreenBack = document.getElementById('lock_screen_back')
        lockScreenBack.style.zIndex = -1

        window.addEventListener('resize', () => {
            let x = document.body.clientWidth
            let y = document.body.clientHeight
            let r = Math.sqrt(x * x + y * y)
            let size = parseInt(r)
            this.lockScreenSize = size
            lockScreenBack.style.transition = 'all 0s'
            lockScreenBack.style.width = lockScreenBack.style.height = size + 'px'
        })
    },
}
