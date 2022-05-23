<script setup>
const { ref }=require("@vue/reactivity");

const props = defineProps({
    color: String,
    suffixText: String,
    icon: String,
    detailLink: String,
    count: String,
});

// const interval = ref('week');

</script>

<template>
<div class="bg-white rounded shadow p-2 w-full">
    <div class="flex relative border border-dashed">

        <div class="rounded-l p-2 flex justify-center">
            <div :class="color" class=" rounded shadow ease-in-out duration-200 flex justify-center items-center">
                <i :class="icon" class="text-white px-6 text-2xl"></i>
            </div>
        </div>

        <div class="p-2 flex-1 flex items-center">
            <!-- <div>
                Bu ay
                <select v-model="interval" class="focus:outline-none bg-white rounded h-10 border-none">
                    <option selected value="week">hafta</option>
                    <option value="month">ay</option>
                    <option value="year">yıl</option>
                </select>
            </div> -->
            <div class="py-4">
                <span class="text-3xl ease font-bold">
                    {{ count }} 
                </span>
                <span>{{ suffixText }}</span>
            </div>
        </div>

        <!-- <div class="absolute bottom-0 right-0 -mb-3 -mr-2 shadow-md text-white">
            <a :href="detailLink" :class="color" class="px-3 py-1 rounded font-bold text-sm ease-in-out duration-200" style="color: inherit">
                <i class="right arrow icon"></i>
                Detaylar
            </a>
        </div> -->
        
    </div>
</div>
</template>