// require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

import { Link } from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/App.vue"

import PrimeVue from 'primevue/config';
import Dialog from 'primevue/dialog';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import ConfirmationService from 'primevue/confirmationservice';

// import 'primevue/resources/themes/md-light-indigo/theme.css'
// import 'primevue/resources/primevue.min.css'
// import 'primeicons/primeicons.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
        .use(PrimeVue)
        .use(ToastService)
        .use(ConfirmationService)
        .use(plugin)
        // .component('AppLayout', AppLayout)
        .component('Toast', Toast)
        .component('Link', Link)
        .component('Dialog', Dialog)
        .mixin({ methods: { route } })
        .mount(el);
    },
});

InertiaProgress.init({ color: '#3429ff' });
