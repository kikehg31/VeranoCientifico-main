import {usePage} from "@inertiajs/inertia-vue3";

export const useCan = (permission) => !!usePage().props.value.auth.can[permission];
export const useRoles = (roles) => Object.keys(usePage().props.value.auth.roles).some(role => Object.values(roles).indexOf(role) > -1);
export const useRole = (role) => !!usePage().props.value.auth.roles[role];
