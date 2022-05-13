<script setup>
import { Inertia } from "@inertiajs/inertia";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';

const confirm = useConfirm();
const toast = useToast();

const props = defineProps({
    deleteRoute: null,
    label: String,
    customClass: String,
    toastInfo: String,
});

const deleteAction = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Emin misiniz?',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Evet',
        rejectLabel: 'Vazgeç',
        accept: () => {
            Inertia.delete(props.deleteRoute, {
                onSuccess: () => {
                    toast.add({severity: 'info', summary: 'Silindi', detail: props.toastInfo ?? 'Sorunsuzca kaldırıldı...', life: 3000})
                },
                onError: () => {
                    toast.add({severity: 'error', summary: 'Hata', detail: 'Silme esnasında bir hata ile karşılaşıldı', life: 3000})
                }
            });
        },
        reject: () => {
            //
        }
    })
}
</script>


<template>
    <Button :label="label" icon="pi pi-trash" :class="customClass" class="p-button-danger p-button-text p-button-sm" @click="deleteAction($event)"></Button>
</template>