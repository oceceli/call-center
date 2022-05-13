<script setup>
const { useForm }=require("@inertiajs/inertia-vue3");
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import Button from "primevue/button/Button.vue";
import MultiSelect from 'primevue/multiselect/MultiSelect.vue';
import axios from "axios";
import { useToast } from "primevue/usetoast";

const props = defineProps({
    editRoleObject: Object,
});
const emit = defineEmits([
    'close',
])

const toast = useToast();

const editMode = ref(false);

const permOpts = ref([]);
onMounted(() => {
    axios.get(route('available_perms')).then((response) => {
        permOpts.value = response.data;
        // ['tr' => 'Kullanıcıları görebilir', 'value' => 'show users'], gibi gelen response
    });

    if(props.editRoleObject) {

        editMode.value = true;
        form.name = props.editRoleObject.name;

        // form.selectedPerms = props.editRoleObject.permissions;
        form.selectedPerms = props.editRoleObject.permissions.map((editPerm, index) => {
            return {"value": editPerm.name};
        });
        form.defaults();
    }
});


const form = useForm({
    _method: 'post',
    name: null,
    selectedPerms: [],
});

const submit = () => {
    if(!form.isDirty) {
        emit('close');
        return;
    };

    form.selectedPerms = form.selectedPerms.map((perm) => perm.value);

    if(editMode.value) {
        form._method = 'patch';
        form.post(route('roles.update', {'role': props.editRoleObject.id}), {
            onSuccess: () => {
                emit('close');
                toast.add({severity: 'success', summary: 'Başarılı', detail: 'Rol ve izinler düzenlendi!', life: 3000})
            },
        });
    } else {
        form.post(route('roles'), {
            onSuccess: () => {
                emit('close');
                toast.add({severity: 'success', summary: 'Başarılı', detail: 'Rol eklendi!', life: 3000})
            },
        });
    }
    // emit('close');
}


</script>

<template>
    <div>
        <div class="flex flex-col pb-8">
            <label class="leading-loose">Rol Adı <span class="text-red-500">*</span></label>
            <input v-model="form.name" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-cyan-500 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600 placeholder:text-gray-300" autocomplete="off" placeholder="Temsilci, kullanıcı, yönetici...">
            <div v-if="form.errors.name">
                <small class="text-xs text-red-500">{{ form.errors.name }}</small>
            </div>
        </div>
        <hr>
        <div class="pt-5 w-full flex flex-col gap-2">
            <span>Bu role sahip bir kullanıcı:</span>
            <MultiSelect v-model="form.selectedPerms" :options="permOpts" dataKey="value" optionLabel="tr" placeholder="şunları yapabilir..." display="chip" />
        </div>
        <div class="text-right pt-5">
            <Button @click="submit" label="Kaydet" icon="pi pi-check" class="p-button-sm"></Button>
        </div>
    </div>
</template>