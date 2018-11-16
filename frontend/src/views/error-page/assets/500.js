export default {
    name: 'Error500',
    methods: {
        backPage() {
            this.$router.go(-1)
        },
        goHome() {
            this.$router.push({
                name: 'dashboard',
            })
        },
    },
}
