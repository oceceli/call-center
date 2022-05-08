<template>
    <div>
        <!-- <DataTable :value="users" responsiveLayout="scroll">
            <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"></Column>
        </DataTable> -->

        <div>
        <DataTable :value="users" responsiveLayout="scroll" class="p-datatable-sm"  stripedRows :paginator="true" :rows="10" 
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10,20,30]"
            currentPageReportTemplate="Toplam {totalRecords},  {first} ile {last} arası">
            <template #header>
                <div class="table-header">
                    Products
                    <Button icon="pi pi-refresh" />
                </div>
            </template>
            <Column field="name" header="Name"></Column>
            <Column field="email" header="email"></Column>
           
            <!-- <Column field="price" header="Price">
                <template #body="slotProps">
                    {{formatCurrency(slotProps.data.price)}}
                </template>
            </Column> -->
            <Column field="rating" header="Reviews">
                <template #body>
                    <Rating :modelValue="4" :readonly="true" :cancel="false" />
                </template>
            </Column>
            <!-- <Column header="Status">
                <template #body="slotProps">
                    <span :class="'product-badge status-' + slotProps.data.inventoryStatus.toLowerCase()">{{slotProps.data.inventoryStatus}}</span>
                </template>
            </Column> -->
            <template #footer>
                In total there are {{users ? users.length : 0 }} users.
            </template>
            <template #paginatorstart>
                <Button type="button" icon="pi pi-refresh" class="p-button-text" />
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
// import ProductService from './service/ProductService';


export default {
    layout: AppLayout,
    components: {DataTable, Column, Rating, Button},
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
        

        return { products, columns, formatCurrency  }
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