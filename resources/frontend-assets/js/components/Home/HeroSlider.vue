<template>
    <swiper id="heroSlider">
        <swiper-slide v-if="sliders.length" v-for="slider in sliders">
            <div class="hero-carousel-item" :class="{ 'carousel-cover': slider.cover }">
                <img :src="$app_data.STORAGE_URL + slider.background_image" :alt="slider.name">
                <div class="carousel-content">
                    <h1 v-text="slider.text"></h1>
                    <h3 v-text="slider.secondary_text"></h3>
                    <HeroSliderButton v-if="slider.action == 'button_link'" :link="slider.action_data" />
                    <HeroSliderCountdown v-else-if="slider.action == 'countdown'" :date="slider.action_data.countdown_date" />
                </div>
            </div>
        </swiper-slide>
        <swiper-slide v-else>
            <HeroSliderDefaultSlide />
        </swiper-slide>
    </swiper>

</template>
<script setup>
import HeroSliderCountdown from './HeroSliderCountdown.vue';
import HeroSliderButton from './HeroSliderButton.vue';
import HeroSliderDefaultSlide from './HeroSliderDefaultSlide.vue';

// Import Swiper
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

</script>
<script>
export default {
    props: ["sliders"],
    components: { HeroSliderCountdown }
}
</script>
