<template>
    <div v-if="latest_artists.loaded">
        <div v-if="latest_artists.error" class="text-center">
            <p class="text-danger mb-2">حدث خطأ غير متوقع</p>
            <button class="btn btn-warning mx-auto" @click="refreshArtists">إعادة محاولة <i
                    class="fa fa-redo"></i></button>
        </div>
        <div v-else-if="!latest_artists.data.length">
            <p class="text-center mb-2">لم ينظم لنا أي أحد بعد</p>
        </div>
        <div v-else>
            <swiper
                    :style="{
                    '--swiper-navigation-color': '#000',
                    '--swiper-pagination-color': '#000',
                    '--swiper-navigation-size':'20px'
                    }"
                    :navigation="true"
                    :modules="modules"
                :space-between="20"
                :breakpoints="{ '0': { slidesPerView: 2 }, '500': { slidesPerView: 3 }, '768': { slidesPerView: 4 }, '1000': { slidesPerView: 6 }, '1600': { slidesPerView: 8 } }">
                <swiper-slide v-for="artist in latest_artists.data" :key="artist.id">
                    <JoinedUsArtistItem :artist="artist" />
                </swiper-slide>
            </swiper>
        </div>
    </div>
    <div v-else>
        <JoinedUsLoadingArtists />
    </div>
</template>
<script setup>
//Plugins
import { ref } from 'vue';
import axios from 'axios';

// Components
import JoinedUsArtistItem from './JoinedUsArtistItem.vue';
import JoinedUsLoadingArtists from './JoinedUsLoadingArtists.vue';

// Import Swiper
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from "swiper";
import 'swiper/css';
import "swiper/css/navigation";


const latest_artists = ref({ loaded: false, data: [], error: null });
const modules = [Navigation]

const getLatestArtists = () => {
    axios.get('/api/artists')
        .then((res) => {
            setTimeout(() => {
                latest_artists.value.loaded = true;
            }, 500);
            latest_artists.value.data = res.data.data;
        })
        .catch((error) => {
            latest_artists.value.loaded = true;
            latest_artists.value.error = error;
        });
}

const refreshArtists = () => {
    latest_artists.value.loaded = false;
    latest_artists.value.error = null;
    latest_artists.value.data = [];

    getLatestArtists();
}

//
getLatestArtists();

</script>
