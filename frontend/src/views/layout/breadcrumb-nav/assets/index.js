export default {
    name: 'breadcrumbNav',
    props: {
        currentPath: Array
    },
    methods: {
        itemTitle (item) {
            return item.title
        },
        itemIcon (item) {
            return item.icon
        }
    }
}
