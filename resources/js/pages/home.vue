<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import AnimatedComments from '../components/AnimatedComments.vue'

const welcomeMessage = ref('Bem-vindo a nossa plataforma de jogos!')
const subMessage = ref('aqui você poderá jogar e se divertir com seus amigos com jogos que funcionam em tempo real!')
const ctaText = ref('Comece a Jogar Agora!')
const isAnimating = ref(true)

const floatingItems = ref([
    { id: 1, content: "🎮", x: 5, y: 14, rotation: 10 },
    { id: 1, content: "🎮", x: 15, y: 60, rotation: 10 },
    { id: 1, content: "🎮", x: 35, y: 20, rotation: 10 },
    { id: 1, content: "🎮", x: 55, y: 70, rotation: 10 },
    { id: 2, content: "Diversão garantida!", x: 80, y: 15, rotation: 40 },
    { id: 3, content: "🚀", x: 15, y: 80, rotation: 32 },
    { id: 4, content: "Level up!", x: 75, y: 70, rotation: 50 },
    { id: 5, content: "🏆", x: 10, y: 40, rotation: 32 },
    { id: 6, content: "Jogue com amigos!", x: 85, y: 60, rotation: 45 },
    { id: 7, content: "🌟", x: 90, y: 30, rotation: 84 },
    { id: 8, content: "Novos desafios!", x: 20, y: 90, rotation: 15 },
])

const startPlaying = () => {
    console.log('Iniciando o jogo...')
}

let animationInterval
onMounted(() => {
    animationInterval = setInterval(() => {
        isAnimating.value = !isAnimating.value
        floatingItems.value.forEach(item => {
            item.x = Math.random() * 90 + 5
            item.y = Math.random() * 90 + 5
            item.rotation = Math.random() * 360
        })
    }, 10000)
})

onUnmounted(() => {
    clearInterval(animationInterval)
})
</script>

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

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-200 to-purple-200 overflow-hidden relative flex items-center justify-center">
        <section name="floats-items">
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
        </section>

        <main>
            <div class="text-center relative z-10 bg-white bg-opacity-10 p-8 rounded-xl backdrop-blur-sm">
                <h1 class="text-6xl font-bold mb-4 text-indigo-700" :class="{ 'animate-bounce': isAnimating }">
                    {{ welcomeMessage }}
                </h1>
                <p class="text-xl mb-8 text-indigo-600">
                    {{ subMessage }}
                </p>
                <button @click="startPlaying"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full text-xl transition duration-300 transform hover:scale-105">
                    {{ ctaText }}
                </button>
            </div>
        </main>

        <section name="animated-comments">
            <AnimatedComments />
        </section>
    </div>
</template>