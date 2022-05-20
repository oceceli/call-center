<script setup>
const { ref }=require("@vue/reactivity");
const { watch }=require("@vue/runtime-core");

const props = defineProps({
    model: Object,
});

const emit = defineEmits(['perpageUpdated']);

const perPage = ref();

watch(perPage, (value) => {
    emit('perpageUpdated', value);
});

</script>

<template>
    <div>
        <Component 
        :is="link.url ? 'Link' : 'span' "
        v-for="link in model.links" :key="link"
        :href="link.url"
        v-html="link.label"
        class="px-2 text-gray-300 cursor-default text-base"
        :class="{'text-gray-400 hover:bg-cyan-400 rounded p-1 hover:text-white ease-in-out duration-100 cursor-pointer': link.url, 'bg-gradient-to-r from-sky-500 to-cyan-400 text-white rounded p-1': link.active}"
        />
    </div>
</template>