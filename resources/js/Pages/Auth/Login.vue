<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: 'superuser@example.com',
    password: 'qwerty123456',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<script>
export default {
    layout: BreezeGuestLayout
}
</script>

<template>
    <Head title="Log in" />

    <div class="pb-4">
        <BreezeValidationErrors class="mb-4" />
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="email" value="E-posta" />
            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Şifre" />
            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
        </div>

        <div class="block mt-4">
            <label class="flex items-center">
                <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                <span class="ml-2 text-sm text-gray-600">Beni Hatırla</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Şifrenizi mi unuttunuz?
            </Link>

            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Giriş Yap
            </BreezeButton>
        </div>
    </form>
</template>
