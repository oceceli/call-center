<script>
export default {
    props: [
        "to",
        "compName"
    ],
}
</script>

<template>
    <Link :href="route(to)" :aria-label="route(to)"
        :class="{ 'rounded-xl text-white shadow bg-gradient-to-r from-sky-600 to-cyan-400 hover:to-sky-500': $page.component == compName }" 
        class="px-4 py-3 flex items-center space-x-4 rounded-xl hover:shadow-inner hover:bg-cyan-100  shadow-cyan-500" >
        <slot />
    </Link>
</template>


