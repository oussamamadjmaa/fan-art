<template>
    <div class="countdown-timer countdown_p">
        <div class="countdown_ d-flex">
            <div class="countdown_item">
                <h1 class="number" v-text="countdown.days"></h1>
                <h6 class="text">أيام</h6>
            </div>
            <h1 class="seperator">:</h1>
            <div class="countdown_item">
                <h1 class="number" v-text="countdown.hours"></h1>
                <h6 class="text">ساعات</h6>
            </div>
            <h1 class="seperator">:</h1>
            <div class="countdown_item">
                <h1 class="number" v-text="countdown.mintues"></h1>
                <h6 class="text">دقائق</h6>
            </div>
            <h1 class="seperator">:</h1>
            <div class="countdown_item">
                <h1 class="number" v-text="countdown.seconds"></h1>
                <h6 class="text">ثواني</h6>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

const props = defineProps({
    date: String,
});

const countDone = ref(false);
const countdown = reactive({ days: '00', hours: '00', mintues: '00', seconds: '00' });
const countInterval = ref(null);

const updateTime = () => {
    if (countDone.value) clearInterval(countInterval.value);

    // Set the date we're counting down to
    var countDownDate = new Date(props.date).getTime();

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    if (distance < 0) {
        countDone.value = true;
        countdown.days = countdown.hours = countdown.minutes = countdown.seconds = '00';
    } else {
        // Time calculations for days, hours, minutes and seconds
        countdown.days = Math.floor(distance / (1000 * 60 * 60 * 24));
        countdown.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        countdown.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        countdown.seconds = Math.floor((distance % (1000 * 60)) / 1000);
    }
}

//Start Coutndown
updateTime();
countInterval.value = setInterval(() => {
    updateTime()
}, 1000);

</script>
