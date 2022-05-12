<script setup>
import Rating from 'primevue/rating';
import ListItem from '../../Components/ListItem.vue';
defineProps({
    customer: Object,
});


</script>

<template>
    <div class="border-t">
        <div class="text-sm pt-6 rounded-md">
            <div class="">
                <div class="flex justify-between items-center mb-4 px-2 py-2 border border-dashed cursor-default">
                    <div class="flex gap-5 items-center text-lg">
                        <div class="text-gray-500"><i class="pi pi-user pr-2"></i> Temsilci: </div> 
                        <span>{{ customer.user?.name }}</span>
                    </div>
                    <div class="font-bold text-md text-gray-500">
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
                        <ListItem title="Durum:" :data="customer.is_active ? 'Aktif' : 'Deaktif'" />


                        <div class="flex justify-between border-b border-lime-300 border-dashed py-3 px-6 hover:bg-lime-100 text-lg font-bold"><span>Arama Bilgileri </span></div>
                        <div v-if="customer.call">
                            <ListItem title="Görüşme Durumu:">
                                <span :class="customer.call.status.class">{{ customer.call.status.tr }}</span>
                            </ListItem>
                            <ListItem title="Verilen Puan:">
                                <div class="flex gap-3 items-center">
                                    <Rating :stars="10" :modelValue="customer.call.score" :cancel="false" :readonly="true" />
                                    <span class="text-sm text-gray-400">
                                        ({{customer.call.score}}/10)
                                    </span>
                                </div>
                            </ListItem>
                            <div class="flex justify-between py-3 px-6 hover:bg-lime-200 font-bold"><span>Temsilci Notu: </span></div>
                            <ListItem :title="customer.call.note.full" />
                        </div>
                        <ListItem v-else class="text-xs text-gray-500" title="Temsilcinin müşteriyi araması bekleniyor..." >
                            <span :class="customer.call?.status.class">{{ customer.call?.status.tr }}</span>
                        </ListItem>

                    </div>
                </div>
            </div>
        

        </div>
    </div>
</template>