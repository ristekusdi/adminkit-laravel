import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~jsvectormap': path.resolve(__dirname, 'node_modules/jsvectormap'),
            '~simplebar': path.resolve(__dirname, 'node_modules/simplebar'),
            '~flatpickr': path.resolve(__dirname, 'node_modules/flatpickr'),
            '~notyf': path.resolve(__dirname, 'node_modules/notyf'),
        }
    }
});
