import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                //Backend
                'resources/backend-assets/sass/app.scss',
                'resources/backend-assets/js/app.js',
                'resources/backend-assets/js/guest.js',
                'resources/backend-assets/js/pages/artist_dashboard.js',
                'resources/backend-assets/js/pages/store_dashboard.js',

                //Frontend
                'resources/frontend-assets/sass/app.scss',
                'resources/frontend-assets/js/app.js',
                'resources/frontend-assets/js/pages/home.js',
                'resources/frontend-assets/js/pages/artwork.js',
                'resources/frontend-assets/js/pages/product.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
