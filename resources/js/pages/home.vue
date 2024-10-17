<script setup>
import { useAnimation } from '../composables/useAnimation'
import AnimatedComments from '../components/AnimatedComments.vue'
import FloatingItems from '../components/FloatingItems.vue'

const { isAnimating } = useAnimation(10000)

const startPlaying = () => {
    console.log('Iniciando o jogo...')
}
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-200 to-purple-200 overflow-hidden relative flex items-center justify-center">
        <FloatingItems />

        <main>
            <div class="text-center relative z-10 bg-white bg-opacity-10 p-8 rounded-xl backdrop-blur-sm">
                <h1 class="text-6xl font-bold mb-4 text-indigo-700" :class="{ 'animate-bounce': isAnimating }">
                    Bem-vindo a nossa plataforma de jogos!
                </h1>
                <p class="text-xl mb-8 text-indigo-600">
                    Aqui você poderá jogar e se divertir com seus amigos com jogos que funcionam em tempo real!
                </p>
                <button @click="startPlaying"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full text-xl transition duration-300 transform hover:scale-105">
                    Comece a Jogar Agora!
                </button>
            </div>
        </main>

        <AnimatedComments />
    </div>
</template>