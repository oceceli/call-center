<script setup>
import { Inertia } from "@inertiajs/inertia";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from 'primevue/usetoast';
import Button from 'primevue/button';
import { useForm } from "@inertiajs/inertia-vue3";

const confirm = useConfirm();
const toast = useToast();

const emit = defineEmits(['deleted']);

const props = defineProps({
    deleteRoute: null,
    label: String,
    customClass: String,
    toastInfo: String,

    multipleData: Object,
});

const form = useForm({
    ids: [],
});

const deleteAction = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Emin misiniz?',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Evet',
        rejectLabel: 'Vazgeç',
        accept: () => {
            if(props.multipleData) {
                // sadece IDleri gönderelim
                form.ids = props.multipleData.map((data) => {return data.id;});
                form.delete(props.deleteRoute, {
                    onSuccess: () => {
                        toast.add({severity: 'info', summary: 'Silindi', detail: props.toastInfo ?? 'Çoklu silme işlemi başarılı oldu', life: 3000});
                        emit('deleted');
                    }
                })
            } else {
                Inertia.delete(props.deleteRoute, {
                    onSuccess: () => {
                        toast.add({severity: 'info', summary: 'Silindi', detail: props.toastInfo ?? 'Sorunsuzca kaldırıldı...', life: 3000})
                    },
                    onError: () => {
                        toast.add({severity: 'error', summary: 'Hata', detail: 'Silme esnasında bir hata ile karşılaşıldı', life: 3000})
                    }
                });
            }
        },
        reject: () => {
            //
        }
    })
}
</script>


<template>
    <Button :label="label" icon="pi pi-trash" :class="customClass" class="p-button-danger p-button-sm" @click="deleteAction($event)" title="Sil"></Button>
</template>