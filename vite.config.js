import {defineConfig, loadEnv} from 'vite'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default ({mode}) => {
  const env = {
    ...process.env,
    ...loadEnv(mode, process.cwd()),
  };

  return defineConfig({
    server: {
      host: env.VITE_APP_HOST,
      port: env.VITE_APP_PORT,
      open: false,
    },

    plugins: [
      laravel({
        input: 'resources/js/app.js',
        refresh: true,
      }),

      vue({
        template: {
          transformAssetUrls: {
            base: null,
            includeAbsolute: false,
          },
        },
    }),],
  });
};
