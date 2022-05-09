<script setup>
import Sidebar from "./Partials/Sidebar.vue";
import Topbar from "./Partials/Topbar.vue";
import ConfirmPopup from 'primevue/confirmpopup';
</script>


<template>
  <div class="h-screen relative">

    <div><Sidebar></Sidebar></div>
    <div class="ml-auto lg:w-[75%] xl:w-[80%] 2xl:w-[85%] h-full flex flex-col overflow-hidden">

        <Topbar></Topbar>

        <div class="flex-1 flex flex-col overflow-auto">
            <div class="px-6 pt-6 bg-gray-50 flex-1 shadow">
                <div class="px-3 bg-white rounded-lg shadow-md mb-6 border border-dashed border-cyan-300 hover:border-cyan-500">
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
