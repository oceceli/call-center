<template>
  <DataTable :value="users" 
    class="p-datatable-sm text-sm"
    :rowClass="rowClass"

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
    :globalFilterFields="['name','email']"
    filterDisplay="menu"
    
    >
    <template #header>
        <div class="flex items-center justify-between py-3">
            <div>
                <Button type="button" @click="openCrudForm(null)" icon="pi pi-plus" label="Ekle" class="p-button-outlined p-button-sm"/>
                <!-- <Button icon="pi pi-refresh p-button-sm" style="float: left"/> -->

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
                <!-- <Button icon="pi pi-refresh p-button-sm" style="float: left"/> -->
            </div>
        </div>
    </template>
    

    <Column field="name" header="Temsilci" sortable :exportable="false"></Column>
    <Column field="img_url" header="Görsel" >
        <template #body="field">
            <a v-if="field.data.img_url" target="_blank" :href="field.data.img_url">
                <img :src="field.data.img_url" class="rounded h-10 cursor-pointer" alt="user-avatar">
            </a >
            <span v-else class="cursor-default">
                <user-avatar :userName="field.data.name" />
            </span>
        </template>
    </Column>
    <Column field="email" header="E-posta" sortable></Column>
    <Column field="!!!!!!!" header="Atandı" sortable footer="Toplam: 300 !!!!"></Column>
    <Column field="!!!!!!" header="Arandı" sortable footer="Toplam: 520 !!!!"></Column>
    <Column header="İşlem">
        <template #body="content">
            <span class="p-buttonset text-xs">
                <Button label="Atama" icon="pi pi-link" class="p-button-primary p-button-raised p-button-sm" badge="8" badgeClass="p-badge-primary" :loading="buttonsLoading"></Button>
                <Button label="" icon="pi pi-user-edit" class=" p-button-primary p-button-text p-button-sm" :loading="buttonsLoading" @click="openCrudForm(content.data)"></Button>
                <Button label="" icon="pi pi-trash" class="p-button-danger p-button-text p-button-sm" @click="deleteUser($event, content.data.id)" :loading="buttonsLoading"></Button>
            </span>
        </template>
    </Column>


    <template #paginatorstart>
        <!-- <Button type="button" icon="pi pi-refresh" class="p-button-text" /> -->
    </template>


    <template #footer>
        <div class="flex items-center justify-between border border-dashed p-3 -mx-2">
            <div>
                Toplam kayıt: {{users ? users.length : 0 }}
            </div>
        </div>
    </template>

    <template #loading>
        Lütfen bekleyiniz...
    </template>

    <template #empty>
        Kayıt bulunamadı!
    </template>


    <Dialog :header="editUserObject ? 'Kullanıcı Düzenle' : 'Kullanıcı Ekle'" v-model:visible="visibleCrudForm" :style="{width: '50vw'}"
    closeOnEscape
    modal
    maximizable
    :breakpoints="{'960px': '75vw', '640px': '100vw'}"
    >
        <UserForm @close="closeCrudForm" :editUserObject="editUserObject"></UserForm>
        <!-- <template #footer>
            <Button label="No" icon="pi pi-times"  class="p-button-text"/>
            <Button label="Yes" icon="pi pi-check"  autofocus />
        </template> -->
    </Dialog>

  </DataTable>
</template>
<script>
import AppLayout from "../Layouts/App.vue";
import UserForm from "./Forms/UserForm.vue";
import UserAvatar from "../Components/UserAvatar.vue";

import DataTable from "primevue/datatable/DataTable.vue";
import Column from "primevue/column/Column.vue";
import Button from 'primevue/button';
import {FilterMatchMode} from 'primevue/api';

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";



// import SearchBar from '../Components/SearchBar.vue';
export default {
  layout: AppLayout,
  components: {
    DataTable,
    Column,
    Button,
    UserForm,
    UserAvatar,
    useToast,
      // SearchBar,
  },
  props: {
    users: Object,
  },
  setup() {
    const buttonsLoading = false;
    const tableLoading = false;
    const visibleCrudForm = ref(false);
    const editUserObject = ref(null)
    const filters = ref({'global': {value: '', matchMode: FilterMatchMode.CONTAINS}});
    const toast = useToast();
    

    const rowClass = (data) => {
        return data.is_active == '0' ? 'bg-gray-100' : null;
    };

    const clearFilters = () => {
        filters.value['global'].value = '';
        console.log('Filtreler temizlendi');
    }
    
    const openCrudForm = (userObject) => {
        editUserObject.value = userObject;
        visibleCrudForm.value = true;
    }

    const closeCrudForm = () => {
        visibleCrudForm.value = false;
    };

    const confirm = useConfirm();
    const deleteUser = (event, userId) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Silmek istiyor musunuz?',
            icon: 'pi pi-exclamation-triangle',
            acceptLabel: 'Evet',
            rejectLabel: 'Vazgeç',
            accept: () => {
                Inertia.delete(route('users.destroy', {'user': userId}), {
                    onSuccess: () => {
                        toast.add({severity: 'success', summary: 'Silindi', detail: 'Kullanıcı silindi!', life: 3000})
                    },
                });
            },
            reject: () => {
                //callback to execute when user rejects the action
            }
        });

 
    };


    return { 
    buttonsLoading, 
    clearFilters, 
    filters, 
    tableLoading, 
    visibleCrudForm, 
    openCrudForm,
    editUserObject,
    closeCrudForm,
    deleteUser,
    rowClass,
    };
  },   

  
};
</script>



