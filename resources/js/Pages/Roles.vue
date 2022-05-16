<script setup>
import AppLayout from "@/Layouts/App.vue";
import DataTable from "primevue/datatable/DataTable.vue";
import Column from "primevue/column/Column.vue";
import Button from 'primevue/button';
import { ref } from '@vue/reactivity';
import RoleForm from './Forms/RoleForm.vue';
import DeleteButton from "@/Components/DeleteButton.vue";

const props = defineProps({
    roles: Object,
});

const editRoleObject = ref(null);
const visibleCrudForm = ref(false);

const openCrudForm = (userObject) => {
    editRoleObject.value = userObject;
    visibleCrudForm.value = true;
}

const closeCrudForm = () => {
    visibleCrudForm.value = false;
};



</script>
<script>
export default {
    layout: AppLayout,
}
</script>


<template>
    <div>
        <DataTable  :value="roles" 
            
            responsiveLayout="scroll"
            :resizableColumns="true"
            sortable
            removableSort
            :paginator="true" 
            :rows="20" 
            :rowsPerPageOptions="[10,20,30,50]"
        >
            <template #header>
                <div class="py-3 pl-2 md:pl-0">
                    <Button type="button" @click="openCrudForm(null)" icon="pi pi-plus" label="Yeni Rol Tanımla" class="p-button-outlined p-button-sm"/>
                </div>
            </template>

            <Column field="name" header="Rol" sortable="" :reorderableColumn="false"></Column>
            <Column header="Verilen izinler" :reorderableColumn="false">
                <template #body="{data}">
                    <span class="font-bold cursor-default text-gray-500 hover:text-gray-700 ease-in-out duration-150">
                        {{ data.permissions.length }} izin
                    </span>
                </template>
            </Column>
            <Column field="updated_at" header="Son Güncelleme" :reorderableColumn="false"></Column>
            <Column header="İşlem">
                <template #body="content">
                    <span class="p-buttonset text-xs">
                        <Button label="Düzenle" icon="pi pi-lock-open" class="p-button-primary p-button-raised p-button-sm" @click="openCrudForm(content.data)"></Button>
                        <DeleteButton :deleteRoute="route('roles.destroy', {'role': content.data.id})" />
                    </span>
                </template>
            </Column>
        </DataTable>


        <Dialog :header="editRoleObject ? 'Rol Düzenle' : 'Yeni Rol Tanımla'" v-model:visible="visibleCrudForm" :style="{width: '50vw'}"
        closeOnEscape
        modal
        maximizable
        :breakpoints="{'960px': '75vw', '640px': '100vw'}"
        >
            <RoleForm @close="closeCrudForm" :editRoleObject="editRoleObject"></RoleForm>
        </Dialog>
    </div>
</template>