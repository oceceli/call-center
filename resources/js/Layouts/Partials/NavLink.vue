<script>
export default {
    props: [
        "to",
        "compName"
    ],
}
</script>

<template>
    <Link :href="route(to)" aria-label="dashboard" class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group" :class="{ 'relative rounded-xl text-white bg-gradient-to-r from-sky-600 to-cyan-400': $page.component == compName }">
        <slot />
    </Link>
</template>


