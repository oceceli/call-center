<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <Button label="Small" icon="pi pi-check" class="p-button-sm"  />
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <Dialog>ne diyaloğu ya</Dialog>
          </div>
        </div>
      </div>
    </div>
    
  </BreezeAuthenticatedLayout>
</template>

<script>
import Button from 'primevue/button';
export default {
  components: [Button],
  data() {
    return {
      basicItems: null,
    };
  },
  mounted() {
    this.basicItems = Array.from({ length: 100000 }).map(
      (_, i) => `Item #${i}`
    );
  },
};
</script>
