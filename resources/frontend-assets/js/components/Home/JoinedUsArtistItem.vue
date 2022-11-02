<template>
    <a class="artist-showcase_ text-center text-dark" :href="$app_data.APP_URL+'/artist/oussamatuber'">
        <div class="artist-showcase_-avatar mb-3 avatar-100 mx-auto text-center">
            <img :src="artist.avatar_url" alt="artist name" class="avatar-100">
        </div>
        <div class="artist-showcase_-info">
            <h6 class="mb-0">{{ artist.name }}</h6>
            <small class="text-secondary">{{ artist.country }} ({{ artist.type }})</small>
        </div>
    </a>
</template>
<script>
export default {
    props: ['artist']
}
</script>
