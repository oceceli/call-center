<template>

  <form @submit.prevent="submit" autocomplete="off" class="divide-y divide-gray-200 border-t border-dashed pt-3">
    <div class="text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 pb-4">
      
      <div class="flex flex-col">
        <label class="leading-loose">Ad Soyad <span class="text-red-500">*</span></label>
        <input :disabled="disableFormFields" v-model="form.name" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Ad Soyad">
        <div v-if="form.errors.name">
          <small class="text-xs text-red-500">{{ form.errors.name }}</small>
        </div>
      </div>

      <div class="flex flex-col">
        <label class="leading-loose">E-posta <span class="text-red-500">*</span></label>
        <input :disabled="disableFormFields" v-model="form.email" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Eposta">
        <div v-if="form.errors.email">
          <small class="text-xs text-red-500">{{ form.errors.email }}</small>
        </div>
      </div>

      <div class="flex flex-col">
        <label class="leading-loose">Şifre <span class="text-red-500">{{ editUserObject ? '' : '*' }}</span></label>
        <input :disabled="disableFormFields" v-model="form.password" type="password" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="new-password" placeholder="Şifre">
        <div v-if="form.errors.password">
          <small class="text-xs text-red-500">{{ form.errors.password }}</small>
        </div>
      </div>
      <div class="flex flex-col">
        <label class="leading-loose">Şifre Tekrar <span class="text-red-500">{{ editUserObject ? '' : '*' }}</span></label>
        <input :disabled="disableFormFields" v-model="form.password_confirmation" type="password" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="new-password" placeholder="Şifre">
        <div v-if="form.errors.password">
          <small class="text-xs text-red-500">{{ form.errors.password }}</small>
        </div>
      </div>
      
      <div class="flex flex-col pb-2">
        <label class="leading-loose">Kullanıcı rolü</label>
        <select v-model="form.role_id" class="form-select appearance-none
          block
          w-full
          px-3
          py-1.5
          text-base
          font-normal
          text-gray-700
          bg-white bg-clip-padding bg-no-repeat
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-cyan-500 focus:outline-none" aria-label="select_role">
            <option v-for="(role, index) in roles" :key="index" :value="role?.id">{{ role?.name }}</option>
        </select>
        <div v-if="form.errors.role_id">
          <small class="text-xs text-red-500">{{ form.errors.role_id }}</small>
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

          <input :disabled="disableFormFields" accept="image/*" name="img_url" @change="form.img_url = $event.target.files[0]" type="file" class="absolute opacity-0 h-full w-full" />
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

      <div class="flex flex-col gap-3">
        <label class="leading-loose">Aktif</label>
        <InputSwitch v-model="form.is_active" />
        <div v-if="form.errors.is_active">
          <small class="text-xs text-red-500">{{ form.errors.is_active }}</small>
        </div>
        <p class="text-xs text-gray-400">Deaktif durumdaki kullanıcılar sisteme giriş yapamazlar</p>
      </div>

    </div>


    <div class="pt-4 flex items-center space-x-4">
      <button @click.prevent="$emit('close')" :disabled="disableFormFields" :class="{'disabled cursor-none bg-gray-100': disableFormFields}"  class="flex justify-center items-center w-full text-cyan-500 px-4 py-3 border hover:bg-neutral-100 rounded-md focus:outline-none">
        <i class="pi pi-angle-left pr-2"></i>
        Geri Dön
      </button>
      <button :disabled="disableFormFields" :class="{'disabled cursor-none bg-cyan-800': disableFormFields}" type="submit" class="bg-cyan-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none hover:bg-cyan-600">
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
import axios from "axios";
import InputSwitch from 'primevue/inputswitch';


import { useForm } from '@inertiajs/inertia-vue3'
import { useToast } from 'primevue/usetoast';

export default {
  props: {
    editUserObject: Object,
  },
  components: {
    UserAvatar,
    InputSwitch,
  },
  emits: ['close'],
  setup(props, {emit}) {
    const form = useForm({
      _method: 'post',
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      role_id: null,
      img_url: null,
      is_active: true,
    });

    const editMode = ref(false);
    const disableFormFields = ref(false);
    const toast = useToast();
    const roles = ref([]);

    onMounted(() => {
       axios.get(route('available_roles')).then((response) => {
          roles.value = response.data;
      });

      if(props.editUserObject) {
        // console.log(props.editUserObject);
        editMode.value = true;
        form.name = props.editUserObject.name;
        form.email = props.editUserObject.email;
        if(props.editUserObject.roles[0]) {
          form.role_id = props.editUserObject.roles[0].id;
        }
        form.is_active = Boolean(props.editUserObject.is_active);
        form.defaults();
      } else {
        console.log('UserForm: editUserObject create modunda açıldı');
      }
    });

    

    function submit() {
      
      
      if(editMode.value) {
        if(! form.isDirty) {
          emit('close');
          toast.add({severity: 'info', summary: 'Değişiklik yapılmadı', detail: 'Herhangi bir değişiklik yapılmadı.', life: 3000});
          return;
        }
        disableFormFields.value = true;
        form._method = 'patch',
        form.post(route('users.update', {'user': props.editUserObject.id}), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Kullanıcı düzenlendi!', life: 3000})
          },
          onFinish: () => {
            disableFormFields.value = false;
          }
        });
      }
      else {
        if(! form.isDirty) {
          toast.add({severity: 'error', summary: 'Form boş', detail: 'Lütfen gerekli alanları doldurunuz!', life: 3000})
          return;
        }
        disableFormFields.value = true;
        form.post(route('users.post'), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Kullanıcı eklendi!', life: 3000})
          },
          onFinish: () => {
            disableFormFields.value = false;
          }
        });
      }

      // emit('close');
    }

    return { form, submit, editMode, disableFormFields, roles};
  },
};
</script>