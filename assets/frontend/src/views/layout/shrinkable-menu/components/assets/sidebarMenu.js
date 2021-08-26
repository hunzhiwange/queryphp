export default {
    name: 'sidebarMenu',
    props: {
        shrink: {
            type: Boolean,
            default: true,
        },
        menuList: Array,
        iconSize: Number,
        menuTheme: {
            type: String,
            default: 'dark',
        },
        openNames: {
            type: Array,
        },
    },
    methods: {
        changeMenu(active) {
            this.$emit('on-change', active)
        },
        itemTitle(item) {
            if (item.meta) {
                return this.__(item.meta.title)
            }
            return ''
        },
    },
    updated() {
        this.$nextTick(() => {
            if (this.$refs.sideMenu) {
                this.$refs.sideMenu.updateOpened()
            }
        })
    },
}
