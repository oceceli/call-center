<script setup>
// import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
// import { Link } from '@inertiajs/inertia-vue3';


</script>

<template>

    <div class="h-screen bg-gray-50 flex">

        <div class="bg-white w-1/2 hidden md:flex items-center justify-around bg-gradient-to-r from-sky-600 to-cyan-400 ">
            <div>
                <h1 class="text-white font-bold text-4xl font-sans">Giriş Yap</h1>
                <p class="text-white mt-1">...</p>
            </div>
            <!-- <img class="object-cover h-full w-full" src="https://picsum.photos/1000/1200.webp" alt="random_img"> -->
        </div>

        <div class="w-full md:w-1/2 p-24 flex items-center justify-center">
            <slot />
        </div>
    </div>

    <!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
        <div>
            logo alanı
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div> -->
</template>
