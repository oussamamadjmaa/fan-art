<template>
    <a :href="link.url" class="carousel-link-btn" :style="{ backgroundColor: link.color }" v-text="link.text"></a>
</template>
<script setup>
const props = defineProps({
    link:Object | Array
})
</script>
