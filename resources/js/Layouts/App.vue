<script setup>
import Sidebar from "./Partials/Sidebar.vue";
import Topbar from "./Partials/Topbar.vue";
import ConfirmPopup from 'primevue/confirmpopup';
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import MobileMenu from 'primevue/sidebar';
import { usePage } from "@inertiajs/inertia-vue3";

const initialWidth = ref(window.innerWidth);

const sidebarStatus = ref(false);
onMounted(() => {
    sidebarStatus.value = !isMobile();
});

const isMobile = () => {
    return window.innerWidth < 1024;
};



</script>

<template>
  <div class="h-screen relative">
    <div v-if="isMobile()">
        <MobileMenu v-model:visible="sidebarStatus" position="full" >
            <Sidebar></Sidebar>
        </MobileMenu>
    </div>
    <div v-else :hidden="!sidebarStatus" class="ml-[-100%] fixed z-10 top-0 w-full border-r bg-white transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]">
        <Sidebar :sidebarStatus="sidebarStatus"></Sidebar>
    </div>

    <div class="ml-auto h-full flex flex-col overflow-hidden" :class="{'lg:w-[75%] xl:w-[80%] 2xl:w-[85%]': sidebarStatus}">
        
        <Topbar @openSidebar="sidebarStatus= !sidebarStatus"></Topbar>

        <div class="flex-1 flex flex-col overflow-auto">
            <div class="md:px-6 md:pt-6 bg-gray-50 flex-1 shadow">
                <div class="md:px-3 bg-white md:rounded-lg shadow-md mb-6 md:border border-dashed border-cyan-300 hover:border-cyan-500">
                    <slot />
                </div>
            </div>

            <div class="p-2 flex items-center justify-center bg-opacity-60">
                <div class="font-bold">
                    <a target="_blank" href="https://www.smartmetrics.com.tr" class="text-sm text-blue-400 hover:red-500">oceceli</a>
                </div>
            </div>
        </div>
        <ConfirmPopup></ConfirmPopup>
        <Toast />
    </div>

  </div>
</template>
