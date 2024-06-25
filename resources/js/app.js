import './bootstrap';
import '../scss/app.scss';
import store from './store.js';
import i18n from './i18n';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(store)
            .use(i18n)

            // Laden der Daten aus der store.js, bevor das store Objekt in app gemounted wird.
            store.dispatch('fetchConstants').then(() => {
                app.mount(el);
            }).catch(error => {
                console.error('Failed to fetch constants', error);
            })


        return app;

    },
    progress: {
        color: '#4B5563',
    },

});
