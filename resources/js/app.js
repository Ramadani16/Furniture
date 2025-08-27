import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { Head, Link } from '@inertiajs/vue3';
import * as LucideIcons from 'lucide-vue-next';
import { createPinia } from 'pinia'; // 🟡 Tambahkan ini
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const pinia = createPinia(); // 🟡 Inisialisasi Pinia

    const app = createApp({ render: () => h(App, props) });

    // ⬇️ Register global component seperti Lucide
    for (const [key, component] of Object.entries(LucideIcons)) {
      app.component(key, component);
    }
pinia.use(piniaPluginPersistedstate)
    app.use(plugin)
      .use(pinia) // 🟡 Daftarkan Pinia ke Vue app
      .use(ZiggyVue)
      .mount(el);

    return app;
  },
  progress: {
    color: '#4B5563',
  },
});
