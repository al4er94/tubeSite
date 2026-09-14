import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Inertia — SPA: обычный gtag.js видит только самую первую загрузку.
// Шлём page_view вручную на каждый переход (включая первый, см. send_page_view: false в app.blade.php).
router.on('navigate', (event) => {
    if (typeof window.gtag === 'function') {
        window.gtag('event', 'page_view', {
            page_path: event.detail.page.url,
            page_title: document.title,
        });
    }
});

createInertiaApp({
    title: (title) => title ? `${title} | Pixelify` : 'Pixelify',
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
