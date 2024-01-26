import './bootstrap';
import '../css/app.css';
import 'material-design-icons-iconfont';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import formatDate from "@/Plugins/formatDate.js";
import formatCount from "@/Plugins/formatCount.js";
import trans from "@/Plugins/trans.js";

createInertiaApp({
  title(title) {
    return title;
  },

  resolve(name) {
    const path = `./Pages/${name}.vue`;
    const pages = import.meta.glob('./Pages/**/*.vue');

    return resolvePageComponent(path, pages)
  },

  setup({el, App, props, plugin}) {
    const rootComponent = {
      render: () => h(App, props)
    };

    return createApp(rootComponent)
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(formatDate)
      .use(formatCount)
      .use(trans)
      .mount(el);
  },

  progress: {
    // The delay after which the progress bar will appear, in milliseconds...
    delay: 0,

    // The color of the progress bar...
    color: '#29d',
  },
});
