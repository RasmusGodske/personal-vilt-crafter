import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
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
    server: {
      hmr: {
        host: 'localhost',
      },
      watch: {
        usePolling: false,
      },
    },
    resolve: {
      alias: {
          'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
      },
  },
});