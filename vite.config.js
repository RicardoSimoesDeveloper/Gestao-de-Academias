import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        // Força o servidor a rodar em IPv4 (resolve o erro do [::1])
        host: '127.0.0.1', 
        port: 5173,
        strictPort: true,
        // Permite que qualquer domínio (academia1.aplicacao.local) acesse os assets
        cors: {
            origin: '*',
            methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
            allowedHeaders: ['X-Requested-With', 'content-type', 'Authorization'],
        },
        // Configuração vital para o Hot Reload funcionar no subdomínio
        hmr: {
            host: '127.0.0.1',
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});