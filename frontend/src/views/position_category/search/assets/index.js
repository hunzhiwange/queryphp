import http from "@/utils/http";

export default {
    data() {
        return {
            searchForm: {
                key: "",
                status: ""
            },
            searchRule: {},
            searchItem: {
                status: [
                    { status: "enable", title: __("启用") },
                    { status: "disable", title: __("禁用") }
                ]
            }
        };
    },
    methods: {
        search(form) {
            // this.apiGet('position_category', {}, this.searchForm).then((res) => {
            //     this.$emit("getDataFromSearch", res.data)
            // })
            // 简单搜索不用请求后台
            this.$emit("getDataFromSearch", this.searchForm);
        },
        add() {
            this.$emit("add");
        }
    },
    mixins: [http]
};
