<template>
    <DataTable :value="customers"  
    class="p-datatable-sm  text-sm"
    :rowClass="rowClass"
    
    dataKey="id"
    v-model:selection="selectedCustomers"

    :rowHover="true"
    responsiveLayout="stack"

    :resizableColumns="true"
    
    sortable
    removableSort
    
    :loading="tableLoading"

    :paginator="true" 
    :rows="20" 
    :rowsPerPageOptions="[10,20,30,50]"
    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
    currentPageReportTemplate="{first} ile {last} arası gösteriliyor"

    v-model:filters="filters"
    :globalFilterFields="['name', 'surname', 'email', 'phone', 'city', 'source', 'category', 'is_active', 'call.status.tr', 'call?.score', 'call?.note']"
    filterDisplay="menu"

    >
    <template #header>
        <div class="flex items-center justify-between py-3 pl-2 md:pl-0">
            <div class="flex gap-2">
                <Button type="button" @click="openCrudForm(null)" icon="pi pi-plus" label="Ekle" class="p-button-outlined p-button-sm"/>
                <Button @click="toggleAssigneePanel" v-show="selectedCustomers.length" type="button" icon="pi pi-link" label="Kullanıcıya ata" class="p-button-sm p-button-success"/>

                <OverlayPanel ref="assigneePanel" :showCloseIcon="true" :dismissable="false" :breakpoints="{'960px': '75vw', '640px': '100vw'}" :style="{width: '450px'}">
                  <Assignee :selectedCustomers="selectedCustomers" />
                </OverlayPanel>

            </div>
            <div class="flex gap-5">
                <Button type="button" icon="pi pi-filter-slash" label="Temizle" class="p-button-text p-button-rounded p-button-sm" @click="clearFilters()"/>
                <div hidden class="md:block">
                    <div class="relative flex items-center text-gray-400 focus-within:text-cyan-400">
                        <span class="absolute left-4 h-6 flex items-center pr-3 border-r border-gray-300">
                        <i class="pi pi-search"></i>
                        </span>
                        <input v-model="filters['global'].value" type="search" name="leadingIcon" id="leadingIcon" placeholder="Tabloda ara" class="w-full pl-14 pr-4 py-2.5 rounded-xl text-sm text-gray-600 outline-none border border-gray-300 focus:border-cyan-300 transition">
                    </div>
                </div>
            </div>
        </div>
    </template>
    <Column selectionMode="multiple" headerStyle="width: 3em"></Column>
    <Column field="is_active" header="Aktif" sortable>
      <template #body={data}>
        <div class="flex items-center justify-center">
            <i v-if="data.is_active" class="pi pi-check text-green-500"></i>
            <i v-else class="pi pi-times"></i>
        </div>
      </template>
    </Column>
    <Column field="name" header="Müşteri Ad" sortable :exportable="true"></Column>
    <Column field="surname" header="Soyad" sortable :exportable="true"></Column>
    
    <Column field="phone" header="Telefon" sortable>
      <template #body="{data}">
        <a v-if="data.is_active" class="text-cyan-600 hover:text-cyan-500" :href="'tel:' + data.phone">
          <i class="pi pi-phone pr-1"></i> 
          {{ data.phone }}
        </a>
        <span v-else>
          {{ data.phone }}
        </span>
      </template>
    </Column>
    
    <Column field="email" header="E-posta" sortable>
      <template #body="{data}">
        <a v-if="data.is_active && data.email" class="text-cyan-600 hover:text-cyan-500" :href="'mailto:' + data.email">
          <i class="pi pi-at pr-1"></i> 
          {{ data.email }}
        </a>
        <span v-else>
          {{ data.email }}
        </span>
      </template>
    </Column>

    <Column field="city" header="Şehir" sortable></Column>
    <Column field="source" header="Kaynak" sortable></Column>
    <Column field="category" header="Kategori" sortable></Column>
    
  
    <Column field="call.status.tr" header="Durum" sortable>
      <template #body="{data}">
        <div v-if="data.call">
          <div v-if="data.is_active" :class="data.call?.status.class">
            <i :class="data.call?.status.icon"></i>
            {{ data.call?.status.tr }}
          </div>
          <span v-else>
            {{ data.call?.status.tr }}
          </span>
        </div>
        <div v-else>
          <span class="p-2 bg-white border border-dashed rounded text-center font-bold">
            <i class="pi pi-clock pr-1"></i>  
            Sırada
          </span>
        </div>
      </template>
    </Column>

    <!-- <Column field="call.score" header="Puan" sortable></Column> -->
    
    <Column field="call?.note" header="Not">
      <template #body="{data}">
        {{ data.call?.note.sliced }}
      </template>
    </Column>


    <Column header="İşlem">
        <template #body="content">
            <span class="p-buttonset text-xs">
                <Button label="İşlem" icon="pi pi-phone" class="p-button-primary p-button-raised p-button-sm" :disabled="!content.data.is_active" @click="openCallCustomerModal(content.data)"></Button>
                <Button label="" icon="pi pi-eye" class="p-button-primary p-button-text p-button-sm" @click="openDetailsModal(content.data)"></Button>
                <Button label="" icon="pi pi-user-edit" class="p-button-primary p-button-text p-button-sm" @click="openCrudForm(content.data)"></Button>
                <DeleteButton toastInfo="Müşteri ile ilgili veriler silindi" :deleteRoute="route('customers.destroy', {'customer': content.data.id})" />
            </span>
        </template>
    </Column>
    

    <template #paginatorstart>
        <!-- <Button type="button" icon="pi pi-refresh" class="p-button-text" /> -->
    </template>


    <template #footer>
        <div class="flex items-center justify-between border border-dashed p-3 -mx-2">
            <div>
                Toplam kayıt: {{customers ? customers.length : 0 }}
            </div>
        </div>
    </template>

    <template #loading>
        Lütfen bekleyiniz...
    </template>

    <template #empty>
        Kayıt bulunamadı!
    </template>


    <Dialog :header="editCustomerObject ? 'Müşteri Düzenle' : 'Müşteri Ekle'" v-model:visible="visibleCrudForm" :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <CustomerForm @close="closeCrudForm" :editCustomerObject="editCustomerObject"></CustomerForm>
    </Dialog>
    
    
    <Dialog header="Müşteri ve Görüşme Detayları" v-model:visible="visibleDetailsModal" :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <CustomerDetails :customer="customerObject" />
    </Dialog>
    
    
    <Dialog header="Arama/Değerlendirme" v-model:visible="visibleCallCustomer" :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <CallCustomer @close="closeCallCustomerModal" :customer="customerObject" />
    </Dialog>
    
    
    <!-- <Dialog header="Arama/Değerlendirme" v-model:visible="visibleCallCustomer" :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <CallCustomer @close="closeCallCustomerModal" :customer="customerObject" />
    </Dialog> -->


  </DataTable>
</template>




<script>
import AppLayout from '../Layouts/App.vue';
import CallCustomer from "./Forms/CallCustomer.vue";
import CustomerForm from "./Forms/CustomerForm.vue";
import CustomerDetails from "./Details/CustomerDetails.vue";
import UserAvatar from "../Components/UserAvatar.vue";

import DataTable from "primevue/datatable/DataTable.vue";
import Column from "primevue/column/Column.vue";
import Button from 'primevue/button';
import {FilterMatchMode} from 'primevue/api';

import { ref, watchEffect } from 'vue';
import { useToast } from 'primevue/usetoast';
import DeleteButton from "@/Components/DeleteButton.vue";

import OverlayPanel from 'primevue/overlaypanel';
import Assignee from './Forms/Assignee.vue';

export default {
  layout: AppLayout,
  props: {
    customers: Object,
  },
  components: {
    DataTable,
    Column,
    Button,
    CustomerForm,
    UserAvatar,
    useToast,
    CustomerDetails,
    CallCustomer,
    DeleteButton,

    OverlayPanel,
    Assignee,
  },


  setup() {
    const editCustomerObject = ref(null);
    const tableLoading = ref(false); // !!!!!
    const buttonsLoading = ref(false); // !!!!
    const filters = ref({'global': {value: '', matchMode: FilterMatchMode.CONTAINS}});

    const visibleCrudForm = ref(false);
    const visibleDetailsModal = ref(false);

    const visibleCallCustomer = ref(false);

    const customerObject = ref(null);

    const selectedCustomers = ref([]);

    const assignee = ref();
    const assigneePanel = ref(null);

    const clearFilters = () => {
      filters.value['global'].value = '';
      console.log('Filtreler temizlendi');
    }
    
    const openCrudForm = (userObject) => {
      editCustomerObject.value = userObject;
      visibleCrudForm.value = true;
    }

    const closeCrudForm = () => {
      visibleCrudForm.value = false;
    };

    const openDetailsModal = (customer) => {
      customerObject.value = customer;
      visibleDetailsModal.value = true;
    }
    
    // const closeDetailsModal = () => {
    //   visibleDetailsModal.value = false;
    // }
    
    const openCallCustomerModal = (customer) => {
      customerObject.value = customer;
      visibleCallCustomer.value = true;
    }
    
    const closeCallCustomerModal = () => {
      customerObject.value = null;
      visibleCallCustomer.value = false;
    }

    const toggleAssigneePanel = (event) => {
        assigneePanel.value.toggle(event);
    };

    const rowClass = (row) => {
      if(!row.is_active) {
        return 'bg-slate-100 text-gray-400 cursor-not-allowed';
      }
      if(row.call?.status.enum == 'BUSY') {
        return 'bg-red-50 text-gray-400 hover:bg-red-100';
      } else if(row.call?.status.enum == 'POSITIVE') {
        return 'bg-lime-50 text-gray-400 hover:bg-lime-100';
      }
    };

    return {
      filters,
      editCustomerObject,

      clearFilters,
      visibleCrudForm,
      openCrudForm,
      closeCrudForm,

      visibleDetailsModal,
      openDetailsModal,
      // closeDetailsModal,
      customerObject,

      tableLoading,
      buttonsLoading,

      openCallCustomerModal,
      closeCallCustomerModal,
      visibleCallCustomer,

      selectedCustomers,

      assignee,
      assigneePanel,
      toggleAssigneePanel,

      rowClass,
    };
  },


}
</script>