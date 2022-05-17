<script setup>
    defineProps({
        title: String,
        data: null,
    });
</script>

<template>
    <div class="flex justify-between items-center border-b border-gray-300 border-dashed py-3 px-6 text-md hover:bg-gray-100 cursor-default hover:text-gray-800 ease-in-out duration-100">
        <span class="">{{ title }} </span>
        <span v-if="data" class="font-semibold">{{ data }}</span> 
        <slot v-else /> 
    </div>
    
</template>