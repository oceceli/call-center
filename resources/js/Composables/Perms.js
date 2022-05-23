import { usePage } from "@inertiajs/inertia-vue3";

export const permittedTo = function(permission) {
    let userPermissions = Array.from(usePage().props.value.auth.all_permissions);
    return userPermissions.includes(permission);
}

export const notPermittedTo = (permission) => {
    return ! permittedTo(permission);
}