export default {
    name: "sidebarMenuShrink",
    props: {
        menuList: {
            type: Array
        },
        iconColor: {
            type: String,
            default: "white"
        },
        menuTheme: {
            type: String,
            default: "darck"
        }
    },
    methods: {
        changeMenu(active) {
            this.$emit("on-change", active);
        },
        itemTitle(item) {
            if (item.meta) {
                return item.meta.title;
            }
            return "";
        }
    }
};
