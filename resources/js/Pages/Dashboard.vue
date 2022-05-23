<script setup>
import AppLayout2 from '../Layouts/App2.vue';
import OverviewCard from '@/Components/OverviewCard.vue';
import DataTable from "primevue/datatable/DataTable.vue";
import Column from "primevue/column/Column.vue";
import Rating from 'primevue/rating';
import Button from 'primevue/button';
import { ref } from '@vue/reactivity';
import CustomerDetails from "./Details/CustomerDetails.vue";
import { onMounted, watch, watchEffect } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import Paginator from "@/Components/Paginator.vue";
import { permittedTo, auth } from '@/Composables/Perms';


const props = defineProps({
  data: Object,
  counts: Object,
  filters: Object,
  // perPage: Object,
});

onMounted(() => {
  dateFrom.value = (props.filters.dateFrom);
  dateTo.value = (props.filters.dateTo);
  filterCall(props.filters.callType);
  // perPage.value = (props.filters.perPage);
});

// const perPage = ref(10);

const dateFrom = ref();
const dateTo = ref();

const callType = ref();
const tableTitle = ref();

watch(dateFrom, () => {
  inertiaGet();
});

watch(dateTo, () => {
  inertiaGet();
});

const inertiaGet = () => {
  Inertia.get(route('dashboard'), {
      dateFrom: dateFrom.value,
      dateTo: dateTo.value,
      callType: callType.value,
      // perPage: perPage.value,
    }, {
    preserveState: true,
    // replace: true,
  })
};

const filterCall = (value) => {
  callType.value = value;
  if(value == 'successfulCalls') tableTitle.value = 'Yapılan görüşmeler';
  else if(value == 'unsuccessfulCalls') tableTitle.value = 'Meşgul / Ulaşılamayan Aramalar';
  else tableTitle.value = 'Tüm Aramalar';
  inertiaGet();
};

const visibleDetailsModal = ref(false);
const customerObject = ref(null);
const openDetailsModal = (customer) => {
  customerObject.value = customer;
  visibleDetailsModal.value = true;
}


</script>
<script>
export default {
  layout: AppLayout2
}
</script>

<template>

  <div>
    <div class="md:-mx-6 md:-mt-6 bg-white shadow p-4 ">
      <span class="font-semibold">Tarih aralığı:</span>
      <input v-model="dateFrom" type="date" class="rounded border-none">
      -
      <input v-model="dateTo" type="date" class="rounded border-none">

    </div>
    <div class="h-full md:py-6">
      <div class="w-full flex flex-col md:flex-row justify-between md:gap-5">
        <OverviewCard @click="filterCall('totalCalls')" class="cursor-pointer hover:bg-slate-500 hover:text-white hover:shadow-md duration-100 ease-in-out" color="bg-cyan-500" suffixText=" arama yapıldı" :count="counts.total_calls.toString()" icon="pi pi-phone" />
        <OverviewCard @click="filterCall('successfulCalls')" class="cursor-pointer hover:bg-slate-500 hover:text-white hover:shadow-md duration-100 ease-in-out" color="bg-green-500" suffixText=" görüşme sağlandı" :count="counts.successful_calls.toString()" icon="pi pi-phone" />
        <OverviewCard @click="filterCall('unsuccessfulCalls')" class="cursor-pointer hover:bg-slate-500 hover:text-white hover:shadow-md duration-100 ease-in-out" color="bg-red-500" suffixText=" meşgul ya da cevapsız çağrı" :count="counts.unsuccessful_calls.toString()" icon="pi pi-phone" />
      </div>

      <div class="pt-8">
        <span class="font-bold text-xl pl-4 md:pl-0">
          {{ tableTitle }}
        </span>
        <span class="text-sm text-gray-600"> ({{ dateFrom + ' | ' + dateTo}})</span>
      </div>

      <div class="p-1 bg-white rounded shadow mt-6">
          <DataTable :value="data" responsiveLayout="scroll" :rowHover="true" sortable>
              <Column sortable field="customer.name_surname" header="Müşteri"></Column>
              <!-- <Column sortable field="customer.surname" header="Soyadı"></Column> -->
              <!-- <Column sortable field="customer.city" header="Şehir"></Column> -->
              <!-- <Column sortable field="customer.source" header="Kaynak"></Column> -->
              <Column sortable field="human_readable_date" header="Arandı"></Column>
              <Column sortable field="status.tr" header="Durum"></Column>
              <Column v-if="callType != 'unsuccessfulCalls'" sortable field="score" header="Puan">
                <template #body="content">
                  <div class="md:flex gap-3 items-center hidden">
                    <Rating :stars="10" :modelValue="content.data.score" :cancel="false" :readonly="true" />
                    <span class="text-sm text-gray-400">
                        ({{content.data.score ?? 0}}/10)
                    </span>
                  </div>
                  <div class="flex md:hidden">
                    ({{content.data.score ?? 0}}/10)
                  </div>
                </template>
              </Column>
              <Column field="note.sliced" header="Not" />
              <Column header="İncele">
                <template #body="content">
                    <Button icon="pi pi-eye" class="p-button-primary p-button-sm" @click="openDetailsModal(content.data.customer)"></Button>
                </template>
              </Column>
              
              <template #footer>
                <div class="flex items-center justify-between border border-dashed p-3 -mx-2">
                    <div>
                        Toplam kayıt: {{data ? data.length : 0 }}
                    </div>
                    <div class="flex gap-5 justify-center items-center">
                      <Paginator :model="data" />
                    </div>
                  </div>
              </template>

          </DataTable>
      </div>


      
      <Dialog header="Müşteri ve Görüşme Detayları" v-model:visible="visibleDetailsModal" :style="{width: '50vw'}"
      closeOnEscape
      modal
      maximizable
      :breakpoints="{'960px': '75vw', '640px': '100vw'}"
      >
          <CustomerDetails :customer="customerObject" />
      </Dialog>


    </div>
  </div>
</template>