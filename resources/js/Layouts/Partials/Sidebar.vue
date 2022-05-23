<template>
    <aside class="flex flex-col justify-between h-screen">
        <div class="pb-6 pt-8 px-6 text-center border-b flex flex-col items-center">
            
            <div @click="openCrudForm(auth.user)" class="cursor-pointer rounded-full w-max">
                <img v-if="auth.user.img_url" :src="auth.user.img_url" class="w-10 h-10 m-auto rounded-full object-cover lg:w-28 lg:h-28">
                <span v-else>
                    <user-avatar customClass="w-10 h-10 m-auto rounded-full object-cover lg:w-28 lg:h-28" :userName="auth.user.name" />
                </span>
            </div>
            <div class="cursor-default">
                <h5 class="hidden mt-4 text-xl font-semibold text-gray-600 lg:block">{{ auth.user.name }}</h5>
                <span class="hidden text-gray-400 lg:block hover:text-gray-600 ease-in-out duration-100">{{ auth.role }}</span>
            </div>
        </div>
        <div class="flex-1 px-6 py-6">

            <ul class="space-y-2 tracking-wide">
                <li v-for="link in links" :key="link.toRouteName">
                    <NavLink v-if="link.userHasAccess" :to="link.toRouteName" :compName="link.component">
                        <i :class="link.icon"></i>
                        <span class="-mr-1 font-mediumd">{{ link.displayName }}</span>
                    </NavLink>
                </li>
            </ul>
        </div>
                <!-- {{ auth.user }} -->

        <div class="border-t">
            <!-- <button class="flex space-x-4 rounded-md text-gray-600"> -->
            <Link :href="route('logout')" method="post" as="button" type="button" class="hover:text-red-500 p-6">
                <i class="pi pi-sign-out pr-2"></i>
                Çıkış yap
            </Link>
            <!-- </button> -->
        </div>



        <Dialog header="Hesabımı Düzenle" v-model:visible="visibleCrudForm" :style="{width: '50vw'}"
        closeOnEscape
        modal
        maximizable
        :breakpoints="{'960px': '75vw', '640px': '100vw'}"
        >
            <UserForm @close="closeCrudForm" :editUserObject="editUserObject"></UserForm>
            <!-- <template #footer>
                <Button label="No" icon="pi pi-times"  class="p-button-text"/>
                <Button label="Yes" icon="pi pi-check"  autofocus />
            </template> -->
        </Dialog>
    </aside>

    

</template>


<script setup>
    import NavLink from "../Partials/NavLink.vue";
    import { usePage } from '@inertiajs/inertia-vue3'
    import { computed, onMounted, onUnmounted, ref } from "@vue/runtime-core";
    import UserAvatar from "../../Components/UserAvatar.vue";
    import UserForm from "../../Pages/Forms/UserForm.vue";
    import { permittedTo } from '@/Composables/Perms';

    

    defineProps({
        sidebarStatus: Boolean,
    });

    const editUserObject = ref(null);
    const visibleCrudForm = ref(false);
    const openCrudForm = (userObject) => {
        editUserObject.value = userObject;
        visibleCrudForm.value = true;
    }
    const closeCrudForm = () => {
        visibleCrudForm.value = false;
    };

    const auth = computed(() => {
        return usePage().props.value.auth;
    });

    const links = ref([
        {
            toRouteName: "dashboard",
            component: "Dashboard",
            icon: "pi pi-th-large",
            displayName: "Anasayfa",
            userHasAccess: permittedTo('view dashboard'),
        },
        {
            toRouteName: "users",
            component: "Users",
            icon: "pi pi-user",
            displayName: "Kullanıcılar",
            userHasAccess: permittedTo('view users'),
        },
        {
            toRouteName: "customers",
            component: "Customers",
            icon: "pi pi-phone",
            displayName: "Müşteriler",
            userHasAccess: permittedTo('view customers'),
        },
        // {
        //     toRouteName: "dashboard",
        //     component: "Reports",
        //     icon: "pi pi-chart-bar",
        //     displayName: "Raporlar",
        //     userHasAccess: permittedTo('view dashboard'),
        // },
        {
            toRouteName: "roles",
            component: "Roles",
            icon: "pi pi-lock",
            displayName: "Roller",
            userHasAccess: permittedTo('view roles'),
        },
        {
            toRouteName: "dashboard",
            component: "Settings",
            icon: "pi pi-cog",
            displayName: "Ayarlar",
            userHasAccess: permittedTo('view dashboard'),
        },
        
    ]);
    
</script>