import './bootstrap';
import '../css/app.css';
import 'material-design-icons-iconfont';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import trans from "@/Plugins/trans.js";

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
      .use(trans)
      .mount(el);
  },
});
