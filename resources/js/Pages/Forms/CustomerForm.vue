<template>

  <form @submit.prevent="submit" autocomplete="off" class="divide-y divide-gray-200 border-t border-dashed pt-3">
    <div class="text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 pb-4">
      
      <div class="sm:flex gap-6">
        <div class="flex flex-col w-full">
          <label class="leading-loose">Ad <span class="text-red-500">*</span></label>
          <input :disabled="disableFormFields" v-model="form.name" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Ad">
          <div v-if="form.errors.name">
            <small class="text-xs text-red-500">{{ form.errors.name }}</small>
          </div>
        </div>
        <div class="flex flex-col w-full">
          <label class="leading-loose">Soyad <span class="text-red-500">*</span></label>
          <input :disabled="disableFormFields" v-model="form.surname" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Soyad">
          <div v-if="form.errors.surname">
            <small class="text-xs text-red-500">{{ form.errors.surname }}</small>
          </div>
        </div>
      </div>
      
      <div class="flex flex-col">
        <label class="leading-loose">Telefon <span class="text-red-500">*</span></label>
        <input :disabled="disableFormFields" v-model="form.phone" type="number" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Telefon">
        <div v-if="form.errors.phone">
          <small class="text-xs text-red-500">{{ form.errors.phone }}</small>
        </div>
      </div>
      
      <div class="flex flex-col">
        <label class="leading-loose">E-posta</label>
        <input :disabled="disableFormFields" v-model="form.email" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="E-posta">
        <div v-if="form.errors.email">
          <small class="text-xs text-red-500">{{ form.errors.email }}</small>
        </div>
      </div>

      <div class="flex flex-col w-full">
        <label class="leading-loose">Şehir</label>
        <input :disabled="disableFormFields" v-model="form.city" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Şehir">
        <div v-if="form.errors.city">
          <small class="text-xs text-red-500">{{ form.errors.city }}</small>
        </div>
      </div>

      <div class="sm:flex gap-6">
        <div class="flex flex-col w-full">
          <label class="leading-loose">Veri Kaynağı</label>
          <input :disabled="disableFormFields" v-model="form.source" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Kaynak">
          <div v-if="form.errors.source">
            <small class="text-xs text-red-500">{{ form.errors.source }}</small>
          </div>
        </div>
        <div class="flex flex-col w-full">
          <label class="leading-loose">Kategori</label>
          <input :disabled="disableFormFields" v-model="form.category" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Kategori">
          <div v-if="form.errors.category">
            <small class="text-xs text-red-500">{{ form.errors.category }}</small>
          </div>
        </div>
      </div>
      
      <div class="flex flex-col gap-3">
        <label class="leading-loose">Aktif</label>
        <InputSwitch v-model="form.is_active" />
        <div v-if="form.errors.is_active">
          <small class="text-xs text-red-500">{{ form.errors.is_active }}</small>
        </div>
        <p class="text-xs text-gray-400">Deaktif olarak işaretlenen müşteriler üzerinde oylama işlemi yapılamaz.</p>
      </div>

      <!-- <div class="flex flex-col w-full">
        <label class="leading-loose">Not</label>
        <textarea :disabled="disableFormFields" v-model="form.note" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="İlgili kullanıcılar görebilir"></textarea>
        <div v-if="form.errors.note">
          <small class="text-xs text-red-500">{{ form.errors.note }}</small>
        </div>
      </div> -->

    </div>


    <div class="pt-4 flex items-center space-x-4">
      <button @click.prevent="$emit('close')" :disabled="disableFormFields" :class="{'disabled cursor-none bg-neutral-100': disableFormFields}"  class="flex justify-center items-center w-full text-cyan-500 px-4 py-3 border hover:bg-neutral-100  rounded-md focus:outline-none">
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
import InputSwitch from 'primevue/inputswitch';


import { useForm } from '@inertiajs/inertia-vue3'
import { useToast } from 'primevue/usetoast';

export default {
  props: {
    editCustomerObject: Object,
  },
  components: {
    UserAvatar,
    InputSwitch,
  },
  emits: ['close'],
  
  setup(props, {emit}) {
    const form = useForm({
      _method: 'post',
      // user_id: null,
      name: null,
      surname: null,
      phone: null,
      email: null,
      city: null,
      source: null,
      category: null,
      // status: null,
      // score: null,
      // note: null,
      is_active: true,
    });

    const editMode = ref(false);
    const disableFormFields = ref(false);
    const toast = useToast();

    onMounted(() => {
      if(props.editCustomerObject) {
        editMode.value = true;
        form.name = props.editCustomerObject.name;
        form.surname = props.editCustomerObject.surname;
        form.phone = props.editCustomerObject.phone;
        form.email = props.editCustomerObject.email;
        form.city = props.editCustomerObject.city;
        form.source = props.editCustomerObject.source;
        form.category = props.editCustomerObject.category;
        // form.note = props.editCustomerObject.call?.note.full;
        form.is_active = Boolean(props.editCustomerObject.is_active);
        // form.isDirty false olması için form.defaults() gerekli.
        // aksi takdirde veritabanına gereksiz istek atmış oluruz submit ederken
        form.defaults();
      } else {
        console.log('CustomerForm: editCustomerObject create modunda açıldı');
      }
    });

    

    

    function submit() {
      
      if(editMode.value) {
        if(! form.isDirty) {
          emit('close');
          toast.add({severity: 'info', summary: 'Değişiklik yapılmadı', detail: 'Herhangi bir değişiklik yapılmadı.', life: 3000});
          // disableFormFields.value = false;
          return;
        }
        disableFormFields.value = true;
        form._method = 'patch',
        form.post(route('customers.update', {'customer': props.editCustomerObject.id}), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Düzenleme başarılı!', life: 3000});
          },
          onFinish: () => {
            disableFormFields.value = false;
          }
        });
      }

      else {
        if(! form.isDirty) {
          toast.add({severity: 'error', summary: 'Form boş', detail: 'Lütfen gerekli alanları doldurunuz!', life: 3000})
          // disableFormFields.value = false;
          return;
        }
        disableFormFields.value = true;
        form.post(route('customers.post'), {
          onSuccess: () => {
            emit('close');
            toast.add({severity: 'success', summary: 'Başarılı', detail: 'Ekleme başarılı!', life: 3000})
          },
          onFinish: () => {
            disableFormFields.value = false;
          }
        });
      }

      // emit('close');
    }

    return { form, submit, editMode, disableFormFields};
  },
};
</script>