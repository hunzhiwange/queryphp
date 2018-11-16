<template>
    <Breadcrumb separator="<b class='breadcrumb-separator'>></b>">
        <BreadcrumbItem
            v-for="item in currentPath"
            :to="'/' + item.path"
            :key="item.name"
            ><Icon :type="itemIcon(item)" :class="itemIcon(item)"></Icon>
            {{ itemTitle(item) }}</BreadcrumbItem
        >
    </Breadcrumb>
</template>

<script src="./assets/index.js"></script>
