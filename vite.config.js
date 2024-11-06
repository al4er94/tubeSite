import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/default/bootstrap.min.css',
                'resources/css/default/flaticon.css',
                'resources/css/app.css',
                'resources/css/default/fontawesome-all.min.css',
                'resources/css/default/style.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
