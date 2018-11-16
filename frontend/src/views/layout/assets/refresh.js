export default {
    created() {},
    activated() {
        if (this.$route.query.name) {
            router.replace({
                name: this.$route.query.name,
                query: {
                    refresh: "page"
                }
            });
        } else {
            console.log("refresh fail");
        }
    }
};
