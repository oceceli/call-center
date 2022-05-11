<template>
    <div :class="customClass" class="flex items-center shadow justify-center w-10 h-10 rounded-full bg-gradient-to-r from-sky-600 to-cyan-400">
        <span class="text-white text-4xl font-bold">
            {{ letters }}
        </span>
    </div>
</template>

<script>
import { computed } from '@vue/runtime-core'

export default {
    props: {
        userName: String,
        customClass: String,
    },
    setup(props) {
        const letters = computed(() => {
            return props.userName.slice(0,1);
        });

        return {
            letters,
        }
    }
}
</script>