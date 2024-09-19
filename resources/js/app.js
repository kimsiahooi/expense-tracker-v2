import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config'
import Aura from '@primevue/themes/aura'
import ToastService from 'primevue/toastservice'
import { ZiggyVue } from 'ziggy-js'
import MainLayout from '@/Layouts/MainLayout.vue'

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || MainLayout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(PrimeVue, {
        theme: {
          preset: Aura,
          options: {
            prefix: 'p',
            darkModeSelector: 'light',
            cssLayer: false,
          },
        },
      })
      .use(ToastService)
      .mount(el)
  },
})
