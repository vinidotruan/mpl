import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        cors: {
          origin: 'http://localhost:8000', // Especifique a origem do seu backend
          methods: ["*"],
          allowedHeaders: ['Content-Type', 'Authorization'],
        },
        hmr: {
            host: "localhost"
        }
    }
});
