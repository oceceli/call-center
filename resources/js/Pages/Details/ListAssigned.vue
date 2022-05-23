<script setup>
import { onMounted, ref } from "@vue/runtime-core";
import axios from "axios";
import ListItem from "../../Components/ListItem.vue";
import CustomerDetails from "./CustomerDetails.vue";


const props = defineProps({
    userObjectDetail: Object,
});

const customersOfUser = ref([]);
onMounted(() => {
    axios.get(route('customers_of_user', {'user': props.userObjectDetail.id})).then(res => customersOfUser.value = res.data);
});

const customerObject = ref();
const visibleDetailsModal = ref(false);
const openDetailsModal = (customer) => {
    customerObject.value = customer;
    visibleDetailsModal.value = true;
}


</script>


<template>
    <div class="pt-3 border-t">
        <div class="pb-2 font-semibold">Toplam: {{ customersOfUser.length }}</div>
        <div class="rounded border mb-6 px-2">
            <div v-for="customer in customersOfUser" :key="customer.id" @click="openDetailsModal(customer)" class="flex justify-between items-center p-2 hover:bg-cyan-600 hover:text-white cursor-pointer ease-in-out duration-75">
                <div>{{ customer.name + ' ' + customer.surname }}</div>
            </div>
            <!-- <ListItem v-for="customer in customersOfUser" :key="customer.id" @click="openDetailsModal(customer)" title="İsim:" :data="customer.name + ' ' + customer.surname" /> -->
        </div>
    </div>


    <Dialog header="Müşteri ve Görüşme Detayları" v-model:visible="visibleDetailsModal" 
    :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <CustomerDetails :customer="customerObject" />
    </Dialog>
</template>