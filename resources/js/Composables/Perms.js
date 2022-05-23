import { usePage } from "@inertiajs/inertia-vue3";

export const auth = () => {
    return usePage().props.value.auth;
}

export const permittedTo = function(permission) {
    let userPermissions = Array.from(auth().all_permissions);
    return userPermissions.includes(permission);
}

export const notPermittedTo = (permission) => {
    return ! permittedTo(permission);
}
