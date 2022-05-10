<template>
    <DataTable :value="customers" 
    class="p-datatable-sm text-sm"
  

    dataKey="id"
    responsiveLayout="stack"

    :resizableColumns="true"
    
    sortable
    removableSort
    
    :loading="tableLoading"

    :paginator="true" 
    :rows="10" 
    :rowsPerPageOptions="[10,20,30]"
    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
    currentPageReportTemplate="{first} ile {last} arası gösteriliyor"

    v-model:filters="filters"
    :globalFilterFields="['name', 'surname', 'email', 'phone', 'city', 'source', 'category', 'status', 'score', 'note']"
    filterDisplay="menu"
    
    >
    <!-- !!!!!!! rowClass ekle status bazında boyama yap -->
    <template #header>
        <div class="flex items-center justify-between py-3">
            <div>
                <Button type="button" @click="openCrudForm(null)" icon="pi pi-plus" label="Ekle" class="p-button-outlined p-button-sm"/>
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
    

    <Column field="name" header="Müşteri Ad" sortable :exportable="true"></Column>
    <Column field="surname" header="Soyad" sortable :exportable="true"></Column>
    
    <Column field="email" header="E-posta" sortable>
      <template #body="{data}">
        <a class="text-cyan-600" :href="'mailto:' + data.email">{{ data.email }}</a>
      </template>
    </Column>
    <Column field="phone" header="Telefon" sortable>
      <template #body="{data}">
        <a class="text-cyan-600" :href="'tel:' + data.phone">{{ data.phone }}</a>
      </template>
    </Column>
    <Column field="city" header="Şehir" sortable></Column>
    <Column field="source" header="Kaynak" sortable></Column>
    <Column field="category" header="Kategori" sortable></Column>

    <Column field="status" header="Durum" sortable></Column>
    <Column field="score" header="Puan" sortable></Column>
    <Column field="note" header="Not" sortable></Column>


    <Column header="İşlem">
        <template #body="content">
            <span class="p-buttonset text-xs">
                <!-- <Button label="Atama" icon="pi pi-link" class="p-button-primary p-button-raised p-button-sm" badge="8" badgeClass="p-badge-primary" :loading="buttonsLoading"></Button> -->
                <Button label="" icon="pi pi-eye" class="p-button-primary p-button-raised p-button-sm" :loading="buttonsLoading" @click="openShowModal(content.data)"></Button>
                <Button label="" icon="pi pi-user-edit" class=" p-button-primary p-button-text p-button-sm" :loading="buttonsLoading" @click="openCrudForm(content.data)"></Button>
                <Button label="" icon="pi pi-trash" class="p-button-danger p-button-text p-button-sm" @click="deleteCustomer($event, content.data.id)" :loading="buttonsLoading"></Button>
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
        <!-- <template #footer>
            <Button label="No" icon="pi pi-times"  class="p-button-text"/>
            <Button label="Yes" icon="pi pi-check"  autofocus />
        </template> -->
    </Dialog>

  </DataTable>
</template>




<script>
import AppLayout from '../Layouts/App.vue';
import CustomerForm from "./Forms/CustomerForm.vue";
import UserAvatar from "../Components/UserAvatar.vue";

import DataTable from "primevue/datatable/DataTable.vue";
import Column from "primevue/column/Column.vue";
import Button from 'primevue/button';
import {FilterMatchMode} from 'primevue/api';

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";

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
  },


  setup() {
    const editCustomerObject = ref(null);
    const tableLoading = ref(false); // !!!!!
    const buttonsLoading = ref(false); // !!!!
    const filters = ref({'global': {value: '', matchMode: FilterMatchMode.CONTAINS}});
    const visibleCrudForm = ref(false);

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

    const toast = useToast();
    const confirm = useConfirm();
    const deleteCustomer = (event, customerId) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Bu müşteri ile ilgili tüm veriler silinecek. Devam etmek istiyor musunuz?',
            icon: 'pi pi-exclamation-triangle',
            acceptLabel: 'Evet',
            rejectLabel: 'Vazgeç',
            accept: () => {
                Inertia.delete(route('customers.destroy', {'customer': customerId}), {
                    onSuccess: () => {
                        toast.add({severity: 'success', summary: 'Silindi', detail: 'Müşteri ile ilgili veriler silindi!', life: 3000})
                    },
                });
            },
            reject: () => {
                //callback to execute when user rejects the action
            }
        });

 
    };

    return {
      filters,
      editCustomerObject,

      clearFilters,
      visibleCrudForm,
      openCrudForm,
      closeCrudForm,

      tableLoading,
      buttonsLoading,

      deleteCustomer,
    };
  },


}
</script>