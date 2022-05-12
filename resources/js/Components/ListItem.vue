<script setup>
    defineProps({
        title: String,
        data: null,
    });
</script>

<template>
    <div class="flex justify-between items-center border-b border-lime-300 border-dashed py-3 px-6 text-md hover:bg-lime-100 cursor-default hover:text-gray-800 ease-in-out duration-100">
        <span>{{ title }} </span>
        <span v-if="data">{{ data }}</span> 
        <slot v-else /> 
    </div>
    
</template>