<template>

  <form @submit.prevent="submit" autocomplete="off" class="divide-y divide-gray-200">
    <div class="text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 pb-4">
      
      <div class="flex flex-col">
        <label class="leading-loose">Ad Soyad</label>
        <input :disabled="disableForm" v-model="form.name" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" autocomplete="off" placeholder="Ad Soyad">
        <div v-if="form.errors.name">
          <small class="text-xs text-red-500">{{ form.errors.name }}</small>
        </div>
      </div>

      <div class="flex flex-col">
        <label class="leading-loose">E-posta</label>
        <input :disabled="disableForm" v-model="form.email" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" autocomplete="off" placeholder="Eposta">
        <div v-if="form.errors.email">
          <small class="text-xs text-red-500">{{ form.errors.email }}</small>
        </div>
      </div>

      <div class="flex flex-col">
        <label class="leading-loose">Şifre</label>
        <input :disabled="disableForm" v-model="form.password" type="password" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" autocomplete="new-password" placeholder="Şifre">
        <div v-if="form.errors.password">
          <small class="text-xs text-red-500">{{ form.errors.password }}</small>
        </div>
      </div>
      <div class="flex flex-col">
        <label class="leading-loose">Şifre Tekrar</label>
        <input :disabled="disableForm" v-model="form.password_confirmation" type="password" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" autocomplete="new-password" placeholder="Şifre">
        <div v-if="form.errors.password">
          <small class="text-xs text-red-500">{{ form.errors.password }}</small>
        </div>
      </div>

      <div class=" flex flex-col">
        <div class="flex gap-5 relative p-3 border border-lime-500 border-dashed">

          <div v-if="editMode">
            <a v-if="editUserObject.img_url" target="_blank" :href="editUserObject.img_url">
                <img :src="editUserObject.img_url" class="rounded h-10 cursor-pointer" alt="user-avatar">
            </a >
            <span v-else class="cursor-default">
                <user-avatar :userName="editUserObject.name" />
            </span>
          </div>

          <input :disabled="disableForm" name="img_url" @change="form.img_url = $event.target.files[0]" type="file" class="absolute opacity-0 h-full w-full" />
          <div v-if="form.img_url">
            {{ form.img_url.name }}
          </div>
          <button class=" bg-lime-500 text-white h-full rounded px-4 py-1"><i class="pi pi-upload pr-2"></i> Resim Yükle</button>
          
          <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            <div class="p-2">
              {{ form.progress.percentage }}%
            </div>
          </progress>

          <div v-if="form.errors.img_url">
            <small class="text-xs text-red-500">{{ form.errors.img_url }}</small>
          </div>
        </div>
      </div>
    </div>


    <div class="pt-4 flex items-center space-x-4">
      <button @click.prevent="$emit('close')" :disabled="disableForm" :class="{'disabled cursor-not-allowed bg-gray-800': disableForm}"  class="flex justify-center items-center w-full text-gray-900 px-4 py-3 border hover:bg-neutral-300 bg-neutral-200 rounded-md focus:outline-none">
        <i class="pi pi-angle-left pr-2"></i>
        Geri Dön
      </button>
      <button :disabled="disableForm" :class="{'disabled cursor-not-allowed bg-cyan-800': disableForm}" type="submit" class="bg-cyan-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none hover:bg-cyan-600">
        <i class="pi pi-check pr-2"></i>
        Kaydet
      </button>
    </div>

  </form>

  


</template>

<script>
import { onMounted, onUpdated, reactive, ref } from "vue";
import { Inertia, Method } from "@inertiajs/inertia";
import UserAvatar from "../../Components/UserAvatar.vue";


import { useForm } from '@inertiajs/inertia-vue3'
import { useToast } from 'primevue/usetoast';

export default {
  props: {
    editUserObject: Object,
  },
  components: {
    UserAvatar,
  },
  emits: ['close'],
  setup(props, {emit}) {
    const form = useForm({
      _method: 'post',
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      img_url: null,
      is_active: false,
    });

    const editMode = ref(false);
    const disableForm = ref(false);
    const toast = useToast();

    onMounted(() => {
      if(props.editUserObject) {
        editMode.value = true;
        form.name = props.editUserObject.name;
        form.email = props.editUserObject.email;
        form.is_active = props.editUserObject.is_active;
      } else {
        console.log('UserForm: editUserObject create modunda açıldı');
      }
    });


    function submit() {
      disableForm.value = true;
      
      if(editMode.value) {
        form._method = 'patch',
        form.post(route('users.update', {'user': props.editUserObject.id}), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Kullanıcı düzenlendi!', life: 3000})
          },
          onFinish: () => {
            disableForm.value = false;
          }
        });
      }
      else {
        form.post(route('users.post'), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Kullanıcı eklendi!', life: 3000})
          },
          onFinish: () => {
            disableForm.value = false;
          }
        });
      }

      // emit('close');
    }

    return { form, submit, editMode, disableForm};
  },
};
</script>