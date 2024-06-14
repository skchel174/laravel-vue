import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';

createInertiaApp({
  progress: {
    color: '#4B5563',
  },

  title(title) {
    return `${title} - ${import.meta.env.VITE_APP_NAME}`;
  },

  resolve(name) {
    return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
  },

  setup({el, App, props, plugin}) {
    const root = {
      render: () => h(App, props)
    };

    return createApp(root)
      .use(plugin)
      .use(ZiggyVue)
      .mount(el);
  },
});
