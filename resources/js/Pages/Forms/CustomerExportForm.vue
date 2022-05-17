<script setup>
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const emit = defineEmits(['close']);


const exportData = () => {
    window.open(route('customers_export'));
    // window.open(route('customers_export'), '_blank');
    emit('close');
};


</script>

<template>
    <div class="flex items-center justify-center">
        <Button label="Export" @click="exportData()" />
    </div>
</template>