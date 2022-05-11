<script setup>
const { computed }=require("@vue/runtime-core");
import { usePage } from '@inertiajs/inertia-vue3'

    const pageName = computed(() => {
        let a = {
            Users: 'Kullanıcılar',
            Customers: 'Müşteriler',
            Reports: 'Raporlar',
            Settings: 'Ayarlar',
        };
        return a[usePage().component.value] ?? 'Anasayfa';
    })
</script>

<template>
    <div class="z-10 top-0 h-16 border-b bg-white lg:py-2.5">
        <div class="flex items-center justify-between h-full">
            <div class="pl-5 h-full flex gap-5 items-center justify-between">

                <div class="border-r pr-5">
                    <i class="pi pi-bars text-xl hover:text-cyan-500 cursor-pointer" @click="$emit('openSidebar')"></i>
                </div>

                <h5 class="text-xl text-gray-500 hover:text-cyan-500 cursor-default ease-in-out duration-100 font-medium lg:block">
                    {{ pageName }}
                </h5>

            </div>
            <div class="flex space-x-4 pr-5">
                <button aria-label="chat" class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200">
                    <i class="pi pi-inbox"></i>
                </button>
                <button aria-label="notification" class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200">
                    <i class="pi pi-bell"></i>
                </button>
            </div>
        </div>
    </div>
</template>