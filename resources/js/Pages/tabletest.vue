<template>
    <div class="card">
        <!-- <DataTable :value="users" responsiveLayout="scroll">
            <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"></Column>
        </DataTable> -->

        <div>
        <DataTable :value="users"  class="p-datatable-sm p-datatable-customersssssssssssssss"  
            stripedRows 
            
            responsiveLayout="stack"
            responsiveLayouttttttttt="scroll"

            :paginator="true" 
            :rows="10" 

            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,30]"
            currentPageReportTemplate="Toplam {totalRecords},  {first} ile {last} arası"

            sortMode="multiple"
            removableSort 

            :resizableColumns="true"

            selectionMode="multiple"
            :metaKeySelection="true"
            v-model:selection="selection"

            v-model:expandedRows="expandedRows"

            dataKey="id"
            @rowSelect="onRowSelect"

            :lazy="false"

            editMode="row"
            v-model:editingRows="editingRows"
            @row-edit-save="onRowEditSave"

            scrollHeight="flex"

            rowGroupMode="subheader" 
            groupRowsBy="representative.name"

            ref="dt"
            >

            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Yeni" icon="pi pi-plus" class="p-button-success mr-5" @click="openNew" />
                    <Button label="Sil" icon="pi pi-trash" class="p-button-danger" @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" />
                </template>

                <template #end>
                    <FileUpload mode="basic" accept="image/*" :maxFileSize="1000000" label="Import" chooseLabel="Import" class="mr-2 inline-block" />
                    <Button label="Export" icon="pi pi-upload" class="p-button-help" @click="exportCSV($event)"  />
                </template>
            </Toolbar>

            <template #header>

                <!-- <div style="text-align:left">
                    <MultiSelect :modelValue="selectedColumns" :options="users" optionLabel="header" @update:modelValue="onToggle"
                        placeholder="Select Columns" style="width: 20em"/>
                </div> -->

                <!-- <div class="table-header">
                    Products
                    <Button icon="pi pi-refresh" />
                </div> -->
            </template>

            <!-- <Column :expander="true" headerStyle="width: 3rem" /> -->

            <Column selectionMode="multiple" headerStyle="width: 3em"></Column>

            <Column field="name" header="Name" :sortable="true"></Column>
            <Column field="email" header="email" :sortable="true"></Column>
           
            <Column field="rating" header="Reviews">
                <template #body>
                    <Rating :modelValue="4" :readonly="true" :cancel="false" />
                </template>
            </Column>

            <template #footer>
                In total there are {{users ? users.length : 0 }} users.
            </template>

            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" class="p-button-text" />
            </template>

            <template #paginatorend>
                <Button type="button" icon="pi pi-cloud" class="p-button-text" />
            </template>



            <template #expansion="slotProps">
                <div class="orders-subtable">
                    <h5>Orders for {{slotProps.data.name}}</h5>
                    <DataTable :value="slotProps.data.orders" responsiveLayout="scroll">
                        <Column field="id" header="Id" sortable></Column>
                        <Column field="name" header="name" sortable></Column>
                        <Column field="date" header="Date" sortable></Column>
                        
                        <Column headerStyle="width:4rem">
                            <template #body>
                                <Button icon="pi pi-search" />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>



        </DataTable>
	</div>
	</div>
</template>



<script>
import AppLayout from '../Layouts/App.vue';
import { ref, onMounted } from 'vue';

import DataTable from 'primevue/datatable/DataTable.vue';
import Column from 'primevue/column/Column.vue';
import Rating from 'primevue/rating/Rating.vue';
import Button from 'primevue/button/Button.vue';
import Toolbar from 'primevue/toolbar/Toolbar.vue';
import FileUpload from 'primevue/fileupload/FileUpload.vue';

import { useToast } from 'primevue/usetoast';
// import ProductService from './service/ProductService';


export default {
    layout: AppLayout,
    components: {DataTable, Column, Rating, Button, Toolbar, FileUpload},
    props: {users:Object},
    setup(props) {
        const formatCurrency = (value) => {
            return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
        };
        console.log(props.users);
        // onMounted(() => {
        //     productService.value.getProductsSmall().then(data => products.value = data);
        // })
        const columns = [
            {field: 'name', header: 'Name'},
            {field: 'email', header: 'email'},
        ];

        const products = ref();
        // const users = props.users;
        // const productService = ref(new ProductService());
        
        const selection = ref([]);
        const expandedRows = ref([]);
        const editingRows = ref(null);

        const toast = useToast();
        const onRowSelect = (event) => {
            toast.add({severity: 'info', summary: 'User Selected', detail: 'Name: ' + event.data.name, life: 3000});
        };

        const onRowEditSave = () => {
             toast.add({severity: 'info', summary: 'Kayıt başarılı', detail: 'Kaydedildi!', life: 3000});
        };

        const dt = ref();
        const exportCSV = () => {
            dt.value.exportCSV();
        };

        return { products, columns, formatCurrency, selection, onRowSelect, expandedRows, editingRows, onRowEditSave, exportCSV, dt  }
    }
}
</script>



<style scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @media screen and (max-width: 960px) {
        align-items: start;
	}
}

.product-image {
    width: 50px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.p-dialog .product-image {
    width: 50px;
    margin: 0 auto 2rem auto;
    display: block;
}

.confirmation-content {
    display: flex;
    align-items: center;
    justify-content: center;
}
@media screen and (max-width: 960px) {
	::v-deep(.p-toolbar) {
		flex-wrap: wrap;
        
		.p-button {
            margin-bottom: 0.25rem;
        }
	}
}
</style>