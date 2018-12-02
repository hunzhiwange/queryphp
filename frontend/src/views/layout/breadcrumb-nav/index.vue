<template>
    <Breadcrumb separator="<b class='breadcrumb-separator'>></b>">
        <BreadcrumbItem v-for="item in currentPath" :key="item.name">
            <Icon v-if="item.icon" :type="itemIcon(item)" :class="itemIcon(item)"></Icon>
            {{ itemTitle(item) }}</BreadcrumbItem
        >
    </Breadcrumb>
</template>

<script src="./assets/index.js"></script>
