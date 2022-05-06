<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Button label="Small" icon="pi pi-check" class="p-button-sm" />
      </h2>
    </template>
  </BreezeAuthenticatedLayout>
</template>

<script>
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
export default {
  components: [Button, Dropdown],
  data() {
    return {
      basicItems: null,

      selectedCity: null,
      cities: [
        { name: "New York", code: "NY" },
        { name: "Rome", code: "RM" },
        { name: "London", code: "LDN" },
        { name: "Istanbul", code: "IST" },
        { name: "Paris", code: "PRS" },
      ],
    };
  },
  mounted() {
    this.basicItems = Array.from({ length: 100000 }).map(
      (_, i) => `Item #${i}`
    );
  },
};
</script>
