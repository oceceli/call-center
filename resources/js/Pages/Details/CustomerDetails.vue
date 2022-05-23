<script setup>
import { ref } from '@vue/reactivity';
import Rating from 'primevue/rating';
import ListItem from '../../Components/ListItem.vue';
const props = defineProps({
    customer: Object,
});

const test = () => {
    if(props.customer.call && props.customer.call?.status.enum == "POSITIVE") {
        return 'bg-lime-50';
    } else if(props.customer.call?.status.enum == 'BUSY') {
        return 'bg-red-50';
    } else if(props.customer.call?.status.enum == 'UNANSWERED') {
        return 'bg-orange-50';
    }
    else {
        return 'bg-gray-50';
    }
};


</script>

<template>
    <div class="border-t">
        <div class="text-sm pt-6 rounded-md">
            <div class="">
                <div class="flex justify-between items-center mb-4 px-4 py-4 cursor-default shadow-sm" :class="test()">
                    <div class="flex gap-5 items-center">
                        <div class="text-gray-500"><i class="pi pi-user pr-2 text-cyan-500"></i>  
                            <span v-if="customer.user">{{ customer.user?.name }}</span>
                            <span v-else class="text-xs">Temsilci atanmadı...</span>
                        </div>
                    </div>
                    <span v-if="customer.call" :class="customer.call.status.class" :title="customer.call.updated_at">
                        <i class="pi pi-phone pr-2"></i>
                        {{ customer.call.human_readable_date }} arandı
                    </span>
                    <span v-else class="p-2 bg-white border border-dashed rounded text-center font-bold flex items-center justify-center">
                        <i class="pi pi-clock pr-1"></i>  
                        Sırada
                    </span>
                    
                </div>
            
                <div class="md:p-4 md:shadow-md text-lg">
                    <div class="border border-dashed border-gray-300">
                        
                        <div class="flex justify-between border-b border-gray-300 border-dashed py-3 px-6 hover:bg-gray-100 text-lg font-bold"><span>Müşteri Bilgileri </span></div>


                        <ListItem title="Adı Soyadı:" :data="customer.name_surname" />
                        <ListItem title="Telefon Numarası:" :data="customer.phone" />
                        <ListItem title="E-posta Adresi:" :data="customer.email" />
                        <ListItem title="Yaşadığı Şehir:" :data="customer.city" />
                        <ListItem title="Veri Kaynağı:" :data="customer.source" />
                        <ListItem title="Kategori:" :data="customer.category" />
                        <ListItem title="Durum:">
                            <i v-if="customer.is_active" class="pi pi-check text-green-500"></i>
                            <i v-else class="pi pi-times"></i>
                        </ListItem>
                        <ListItem title="Sisteme Giriş:" :data="customer.created_at" />
                        <ListItem title="Son Güncellenme:" :data="customer.updated_at" />


                        <!-- <ListItem title="Görüşme Durumu:">
                            <div v-if="customer.call" class="text-gray-500 text-xs" :title="customer.call.updated_at">
                                <i class="pi pi-phone pr-2"></i>
                                {{ customer.call.human_readable_date }} arandı
                            </div>
                        </ListItem> -->

                        <div v-if="customer.call">
                            <div class="flex justify-between border-b border-gray-300 border-dashed py-3 px-6 hover:bg-gray-100 text-lg font-bold"><span>Arama Bilgileri </span></div>
                            <ListItem title="Son arama:" :data="customer.call.updated_at" />
                            <ListItem title="Puanlama:">
                                <div class="flex gap-3 items-center">
                                    <Rating :stars="10" :modelValue="customer.call.score" :cancel="false" :readonly="true" />
                                    <span class="text-sm text-gray-400">
                                        ({{customer.call.score ?? 0}}/10)
                                    </span>
                                </div>
                            </ListItem>
                            <div class="flex justify-between py-3 px-6 hover:bg-gray-200 font-bold"><span>Temsilci Notu: </span></div>
                            <ListItem class="text-rose-600 font-bold text-sm" :title="customer.call.note.full" />
                        </div>
                        

                    </div>
                </div>
            </div>
        

        </div>
    </div>
</template>