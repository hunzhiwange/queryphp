import http from '@/utils/http'
import {unlock} from '@/utils/auth'
import avator from '@/assets/images/avator.png'

export default {
    name: 'Unlock',
    data() {
        return {
            avatorLeft: '0px',
            inputLeft: '400px',
            password: '',
            check: null,
            avator: avator,
        }
    },
    props: {
        showUnlock: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        avatorPath() {
            return this.avator
        },
    },
    methods: {
        handleClickAvator() {
            if (this.inputLeft !== '0px') {
                this.handleAvatorHideInput()
            } else {
                this.handleAvatorShowInput()
            }
        },
        handleAvatorHideInput() {
            this.avatorLeft = '-180px'
            this.inputLeft = '0px'
            this.$refs.inputEle.focus()
        },
        handleAvatorShowInput() {
            this.inputLeft = '400px'
            setTimeout(() => (this.avatorLeft = '0px'), 800)
        },
        handleUnlock() {
            if (!this.password) {
                utils.warning(this.__('请输入密码'))
                return
            }

            let data = {
                password: this.password,
            }
            this.apiPost('user/unlock', data).then(res => {
                this.successOnlock()
            })
        },
        successOnlock() {
            this.avatorLeft = '0px'
            this.inputLeft = '400px'
            this.password = ''
            unlock()
            this.$emit('on-unlock')
        },
        handleClickLock(type) {
            if ('logout' === type) {
                this.logout()
            } else if ('lock' === type) {
                this.handleClickAvator()
            }
        },
        logout() {
            this.$Modal.confirm({
                title: this.__('提示'),
                content: this.__('确认退出吗?'),
                onOk: () => {
                    this.changePasswordLogout()
                },
                onCancel: () => {},
            })
        },
        changePasswordLogout() {
            let data = {}
            this.apiPost('login/logout', data).then(res => {
                this.$store.dispatch('logout')
                utils.success(this.__('登出成功'))
                this.successOnlock()
                setTimeout(() => {
                    router.replace('/login')
                }, 1000)
            })
        },
        unlockMousedown() {
            this.$refs.unlockBtn.className = 'unlock-btn click-unlock-btn'
        },
        unlockMouseup() {
            this.$refs.unlockBtn.className = 'unlock-btn'
        },
    },
    mixins: [http],
}
