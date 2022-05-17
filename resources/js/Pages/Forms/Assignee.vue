<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from '@vue/runtime-core';
import axios from 'axios';
import AutoComplete from 'primevue/autocomplete';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';

const emit = defineEmits(['close']);

const toast = useToast();

const props = defineProps({
    selectedCustomers: Array,
});

const filteredUsers = ref();
const users = ref([]);

const selectedUser = ref(null);


onMounted(() => {
    axios.get(route('users_list')).then((res) => {
        users.value = res.data;
    }).catch((error) => {
        console.log(error);
    });
    console.log(users);
});

const searchUsers = (event) => {
    if (!event.query.trim().length) {
        filteredUsers.value = [...users.value];
    }
    else {
        filteredUsers.value = users.value.filter((user) => {
            return user.name.toLowerCase().startsWith(event.query.toLowerCase());
        });
    }
};

const form = useForm({
    customers: [],
});

const submit = () => {
    if(!selectedUser.value) {
        toast.add({severity: 'error', summary: 'Kullanıcı seçilmedi', detail: 'Atamak istediğiniz kullanıcıyı seçiniz...', life: 3000});
        return;
    };

    // sadece IDleri gönderelim
    form.customers = props.selectedCustomers.map((customer) => {return customer.id;});
    
    // console.log(props.selectedCustomers);
    form.post(route('customers_assign', {'user': selectedUser.value.id}), {
        onSuccess: (res) => {
            // toast.add({severity: 'success', summary: 'Atama yapıldı', detail: 'Seçilen müşteriler, ilgili kullanıcıya atandı.', life: 3000});
            toast.add({severity: 'success', summary: 'Atama yapıldı', detail: usePage().props.value.flash.success, life: 3000});
        }
    });
    emit('close');
};


</script>

<template>
    <div class="text-sm pb-2 text-gray-400 hover:text-gray-500 ease-in-out duration-125 cursor-default">
        <i class="pi pi-info-circle pr-2"></i>
        Toplam atanacak {{ selectedCustomers.length }} adet
        <div class="text-red-500">{{ form.errors.customers }}</div>
    </div>
    <div class="flex flex-col gap-2">
        <span class="font-bold">
            Kullanıcı seçiniz
        </span>
        <AutoComplete v-model="selectedUser" :suggestions="filteredUsers" @complete="searchUsers($event)" :dropdown="true" inputClass="text-sm" field="name" key="id" forceSelection>
            <template #item="slotProps">
                <div class="ml-2">{{slotProps.item.name}}</div>
            </template>
        </AutoComplete>
        <span class="p-buttonset text-xs text-right py-4">
            <Button :loading="form.processing" @click="submit()" label="Kaydet" icon="pi pi-check" iconPos="right" class="p-button-success p-button-raised p-button-sm" />
        </span>
        <hr>
        <div class="text-xs pt-2 text-gray-400 hover:text-gray-500 ease-in-out duration-125 cursor-default">
            <i class="pi pi-exclamation-triangle pr-2"></i>
            Seçilen müşteri daha önce atanmışsa eski kullanıcısından kaldırılacaktır
        </div>
    </div>
</template>