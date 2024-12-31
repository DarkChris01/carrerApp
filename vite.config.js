import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: false,
        }),
        svelte({})
    ],
    resolve: {
        alias: {
            '@components': path.resolve(__dirname, './resources/js/Components'),
            '@utils': path.resolve(__dirname, './resources/js/Utils'),
            '@dependencies': path.resolve(__dirname, './resources/js/Dependencies'),
            '@modals': path.resolve(__dirname, './resources/js/Modals'),
            '@forms': path.resolve(__dirname, './resources/js/Forms'),
            
        }
    }
});
