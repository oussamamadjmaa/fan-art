<template>
    <div class="_">
        <div class="__" v-for="i in [1,2,3,5,6,7,8]">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</template>

<style scoped>
._{
    display: flex;
    justify-content: space-between;
    overflow: hidden;
    gap: 1.7rem;
    margin: 1.3rem 0;
}
.__ {
    display: flex;
    flex-direction: column;
    cursor: pointer;
}

.__ span:first-child {
    display: block;
    width: 100px;
    aspect-ratio: 1/1;
    border-radius: 50%;
    background-color: #aaa;
    opacity: .7;
}
.__ span:nth-child(2) {
    display: block;
    width: 100px;
    height: 10px;
    background-color: #aaa;
    margin-top: 3px;
    opacity: .6;
}

.__ span:nth-child(3) {
    display: block;
    width: 80px;
    height: 10px;
    background-color: #aaa;
    margin: 3px auto;
    margin-bottom: 0;
    opacity: .5;
}

._ .__:nth-child(even) {
    transition: all .3s ease-in-out;
    animation: opacityAnimationTwo 1s ease infinite;
}

._ .__:nth-child(odd) {
    transition: all .3s ease-in-out;
    animation: opacityAnimation 1s ease infinite;
}

@keyframes opacityAnimation {
    0% {
        opacity: 1;
    }

    30% {
        opacity: .8;
    }
}

@keyframes opacityAnimationTwo {
    0% {
        opacity: 1;
    }

    60% {
        opacity: .8;
    }
}
</style>
