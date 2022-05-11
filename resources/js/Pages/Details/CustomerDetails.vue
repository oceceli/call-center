<script setup>
import Rating from 'primevue/rating';
import ListItem from '../../Components/ListItem.vue';
defineProps({
    customer: Object,
});


</script>

<template>
    <div class="border-t">
        <div class="text-sm py-6 rounded-md">
            <div class="">
                <div class="flex justify-between items-center mb-4 px-2 py-2 border border-dashed">
                    <div class="flex gap-5 items-center text-lg">
                        <div class="text-gray-500"><i class="pi pi-user pr-2"></i> Temsilci: </div> 
                        <span>{{ customer.User }} xxx user</span>
                    </div>
                    <div>
                        Arama Tarihi: 12.12.2021
                    </div>
                </div>
            
                <div class="p-4 shadow-md ">
                    <div class="border border-dashed border-lime-300">
                        
                        <div class="flex justify-between border-b border-lime-300 border-dashed py-3 px-6 hover:bg-lime-100 text-lg font-bold"><span>Müşteri Bilgileri </span></div>


                        <ListItem title="Adı Soyadı:" :data="customer.name + ' ' + customer.surname" />
                        <ListItem title="Telefon Numarası:" :data="customer.phone" />
                        <ListItem title="E-posta Adresi:" :data="customer.email" />
                        <ListItem title="Yaşadığı Şehir:" :data="customer.city" />
                        <ListItem title="Veri Kaynağı:" :data="customer.source" />
                        <ListItem title="Kategori:" :data="customer.category" />
                        <ListItem title="Durum:" :data="customer.is_active ? 'Aktif' : 'Gizli'" />
                        <ListItem title="Görüşme Durumu:">
                            <span :class="customer.status.class">{{ customer.status.tr }}</span>
                        </ListItem>
                        <ListItem title="Verilen Puan:">
                            <Rating :stars="10" :modelValue="customer.score" :cancel="false" :readonly="true" />
                        </ListItem>
                        <div class="flex justify-between py-3 px-6 hover:bg-lime-200 text-lg font-bold"><span>Temsilci Notu: </span></div>
                        <ListItem :title="customer.note.full" />
                    </div>
                </div>
            </div>
        

        </div>
    </div>
</template>