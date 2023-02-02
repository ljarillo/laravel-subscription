import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'
import Contact from './components/Contact'

const app = createApp({})

app.component('contact-component', Contact)

app.mount('#app')
