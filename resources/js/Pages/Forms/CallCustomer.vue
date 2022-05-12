<script setup>
import ListItem from "../../Components/ListItem.vue";
import Rating from 'primevue/rating';
import { useForm } from "@inertiajs/inertia-vue3";
import SelectButton from 'primevue/selectbutton';
import { ref } from "@vue/reactivity";
import Button from 'primevue/button';
import { onMounted } from "@vue/runtime-core";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";

const props = defineProps({
    customer: Object,
});

const emit = defineEmits(['close']);

const editMode = ref(false);

onMounted(() => {
    if(props.customer.call) {
        editMode.value = true;
        form.score = props.customer.call.score;
        form.note = props.customer.call.note.full;
        form.status.value = props.customer.call.status.enum;
        form.defaults();
    }
});

const toast = useToast();
const confirm = useConfirm();

const form = useForm({
    _method: 'post',
    status: {value: null},
    score: null,
    note: null,
});

const customerStatusOptions = ref([
    {name: 'Görüşme sağlandı', value: "POSITIVE", icon: 'pi pi-check text-green-500'},
    {name: 'Ulaşılamadı', value: "UNANSWERED", icon: 'pi pi-ban text-yellow-500'},
    {name: 'Meşgul', value: "BUSY", icon: 'pi pi-times text-red-500'},
]);


const submit = () => {
    if(!form.isDirty) {
        emit('close');
        return;
    }
    form.status = form.status.value;
    if(editMode.value) {
        form._method = 'patch';
        form.post(route('call.update', {'call': props.customer.call.id}), {
            onSuccess: () => {
                toast.add({severity: 'success', summary: 'Kaydedildi', detail: 'Değerlendirme kaydedildi', life: 3000})
            },
        });
    } else {
        form.post(route('call.post', {'customer': props.customer.id}), {
            onSuccess: () => {
                toast.add({severity: 'success', summary: 'Kaydedildi', detail: 'Değerlendirme kaydedildi', life: 3000})
            },
        });
    }
    emit('close');
}

const deleteCall = () => {
    confirm.require({
        target: event.currentTarget,
        message: 'Değerlendirme kaldırılacak, emin misiniz?',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Evet',
        rejectLabel: 'Vazgeç',
        accept: () => {
            Inertia.delete(route('call.destroy', {'call': props.customer.call?.id}), {
                onSuccess: () => {
                    toast.add({severity: 'info', summary: 'Silindi', detail: 'Değerlendirme kaldırıldı', life: 3000})
                },
            });
            emit('close');
        },
    });
};


</script>

<template>
    <div class="pt-2 border-t -m-6">
        <div class="bg-gray-50 shadow-md py-10 rounded border border-dashed bg-gradient-to-r from-green-100 to-rose-100" >
            <div class="flex justify-center">
                <div class="bg-white rounded-full p-2 shadow-md">
                    <a :href="'tel:' + customer.phone" class="w-40 h-40 rounded-full border-2 border-dashed border-green-400 flex items-center justify-center text-green-400 hover:bg-green-400 hover:text-white">
                        <i class="pi pi-phone text-3xl"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-10 px-6">
            <div class="rounded border mb-6">
                <ListItem title="Adı Soyadı:" :data="customer.name" />
                <ListItem v-if="customer.email" title="E-Posta:" :data="customer.email" />
                <ListItem title="Telefon Numarası:" :data="customer.phone" />

            </div>
            <div v-if="customer.is_active" class="bg-white rounded-md p-6">
                <div class="flex justify-between items-end pb-3">
                    <label class="font-semibold text-gray-400 hover:text-gray-500 ease-in-out duration-100">Görüşmeniz nasıldı?</label>

                    <SelectButton v-model="form.status" :options="customerStatusOptions" dataKey="value" optionLabel="brand">
                        <template #option="slotProps" >
                            <div class="p-2 -mx-4 -my-3">
                                <i :class="slotProps.option.icon"></i>
                                <span class="pl-2" >{{ slotProps.option.name }}</span>
                            </div>
                        </template>
                    </SelectButton>
                </div>

                <div v-if="form.status.value" class="flex flex-col">
                    <textarea v-model="form.note" class="focus:outline-none focus:none border-dashed rounded-md" id="customer_note" cols="30" rows="5"></textarea>
                    <div class="flex justify-between items-center pt-5">
                        <div class="flex items-center gap-3">
                            <div>Puanınız:</div>
                            <Rating :stars="10" v-model="form.score" :cancel="false" /><span v-if="form.score" class="text-sm text-gray-400">({{form.score}}/10)</span>
                        </div>
                        <span class="p-buttonset text-xs">
                            <Button @click="submit()" label="Kaydet" icon="pi pi-check" iconPos="right" class="p-button-primary p-button-raised p-button-sm" />
                            <Button v-if="customer.call" @click="deleteCall()" title="Değerlendirmeyi kaldır" icon="pi pi-trash" class="p-button-danger p-button-text p-button-sm"></Button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>