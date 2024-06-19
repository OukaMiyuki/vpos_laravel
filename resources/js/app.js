import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue/dist/vue.esm-bundler.js';

const app = createApp({});

app.mount("#app");

Vue.component('send-button-otp', require('./components/sendOtpButton.vue'))
