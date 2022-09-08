import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //Backend
                'resources/backend-assets/sass/app.scss',
                'resources/backend-assets/js/app.js',
                'resources/backend-assets/js/guest.js',
                'resources/backend-assets/js/pages/artist_dashboard.js',

                //Frontend
                'resources/frontend-assets/sass/app.scss',
                'resources/frontend-assets/js/app.js',
                'resources/frontend-assets/js/pages/home.js',
                'resources/frontend-assets/js/pages/artwork.js',
            ],
            refresh: true,
        }),
    ],
});
