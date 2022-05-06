<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <BreezeAuthenticatedLayout>
    <template #header> </template>sdf
  </BreezeAuthenticatedLayout>
</template>

<script>
import Dropdown from "primevue/dropdown";

import { defineComponent } from "vue";
import { useToast } from "primevue/usetoast";
export default  {
  components: [Dropdown, useToast],
  data() {
    return {
      basicItems: null,
    };
  },
  mounted() {
    this.$toast.add({
      severity: "success",
      summary: "Success Message",
      detail: "Order submitted",
      life: 3000,
    });

    this.basicItems = Array.from({ length: 100000 }).map(
      (_, i) => `Item #${i}`
    );
  },
};
</script>
