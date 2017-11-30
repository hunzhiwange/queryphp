<template>
    <Breadcrumb separator="<b class='breadcrumb-separator'>></b>">
        <BreadcrumbItem
            v-for="item in currentPath"
            :href="item.path"
            :key="item.name"
        ><Icon :type="itemIcon(item)" :class="itemIcon(item)"></Icon> {{ itemTitle(item) }}</BreadcrumbItem>
    </Breadcrumb>
</template>

<script>
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
};
</script>
