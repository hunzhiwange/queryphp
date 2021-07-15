import sidebarMenu from './../components/sidebarMenu.vue'
import sidebarMenuShrink from './../components/sidebarMenuShrink.vue'

export default {
    name: 'shrinkableMenu',
    components: {
        sidebarMenu,
        sidebarMenuShrink,
    },
    props: {
        shrink: {
            type: Boolean,
            default: false,
        },
        menuList: {
            type: Array,
            required: true,
        },
        theme: {
            type: String,
            default: 'dark',
            validator(val) {
                return utils.oneOf(val, ['dark', 'light'])
            },
        },
        beforePush: {
            type: Function,
        },
        openNames: {
            type: Array,
        },
    },
    computed: {
        shrinkIconColor() {
            return this.theme === 'dark' ? '#fff' : '#495060'
        },
    },
    methods: {
        handleChange(name) {
            let willpush = true
            if (this.beforePush !== undefined) {
                if (!this.beforePush(name)) {
                    willpush = false
                }
            }
            if (willpush) {
                this.$router.push({
                    name: name,
                })
            }
            this.$emit('on-change', name)
        },
    },
}
