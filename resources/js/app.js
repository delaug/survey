require('./bootstrap');

import { createApp } from 'vue'
import App from './App.vue'

// PrimeVue
import 'primevue/resources/themes/saga-blue/theme.css'       //theme
import 'primevue/resources/primevue.min.css'                 //core css
import 'primeicons/primeicons.css'                           //icons

import PrimeVue from "primevue/config"

createApp(App)
    .use(PrimeVue)
    .mount('#app')
