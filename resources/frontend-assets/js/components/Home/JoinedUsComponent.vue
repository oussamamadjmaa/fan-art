<script setup>
import JoinedUsArtistsList from './JoinedUsArtistsList.vue';
const props = defineProps({
    artists_route : String
})
console.log(props)
</script>
<template>
    <section class="latest_artists bg-white painting-border pt-4 pb-2">
        <div class="container pb-1 pt-3">
            <h1 class="mb-2 fs-2"><a href="{{route('frontend.artists.index')}}">إنضم لنا:</a></h1>
            <JoinedUsArtistsList />
            <div class="text-center mt-4">
                <a :href="artists_route" class="primary-btn">عرض كل الفنانين والخطاطين</a>
            </div>
        </div>
    </section>
</template>


