<template>
    <div>
        <Breadcrumb separator="<b class='breadcrumb-separator'>></b>">
            <BreadcrumbItem v-for="item in currentPath">
                <Icon v-if="item.icon" :type="itemIcon(item)" :class="itemIcon(item)"></Icon>
                {{ itemTitle(item) }}</BreadcrumbItem
            >
        </Breadcrumb>
    </div>
</template>

<script src="./assets/index.js"></script>
