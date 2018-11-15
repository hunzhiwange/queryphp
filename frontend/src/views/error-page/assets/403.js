export default {
    name: 'Error403',
    methods: {
        backPage () {
            this.$router.go(-1);
        },
        goHome () {
            this.$router.push({
                name: 'dashboard'
            });
        }
    }
}
