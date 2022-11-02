import './bootstrap';
import './functions';

import { createApp } from 'vue';

const app = createApp({});

import JoinedUsComponent from './components/Home/JoinedUsComponent.vue';
import HeroSlider from './components/Home/HeroSlider.vue';

app.component('joined-us', JoinedUsComponent);
app.component('home-hero-slider', HeroSlider);

app.config.globalProperties.$app_data = GLOBAL;
app.mount('#app');
