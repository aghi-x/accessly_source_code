import '../css/app.css';
import './bootstrap';
import Store from './Store'
import { createInertiaApp, Head  } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';



const appName = import.meta.env.VITE_APP_NAME || 'Accessly';



Store.dispatch('userProfile/initUserProfile')
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Modules/${name}.vue`,
            import.meta.glob('./Modules/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component('Head', Head)  
            .use(plugin)
            .use(ZiggyVue)
            .use(Store)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
