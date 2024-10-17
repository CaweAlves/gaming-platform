<script setup>
import { TransitionGroup } from 'vue'
import { useFloatingItems } from '../composables/useFloatingItems'

const { floatingItems } = useFloatingItems()
</script>

<template>
    <TransitionGroup name="float" tag="div" class="absolute inset-0">
        <div v-for="item in floatingItems" :key="item.id" :style="{
            left: `${item.x}%`,
            top: `${item.y}%`,
            transform: `rotate(${item.rotation}deg)`,
            transition: 'all 10s ease-in-out'
        }" class="absolute text-2xl pointer-events-none">
            {{ item.content }}
        </div>
    </TransitionGroup>
</template>

<style scoped>
.float-enter-active,
.float-leave-active {
    transition: all 0.5s ease;
}

.float-enter-from,
.float-leave-to {
    opacity: 0;
    transform: translateY(30px) rotate(0deg);
}

.float-move {
    transition: all 10s ease;
}
</style>