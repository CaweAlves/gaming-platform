<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const emojis = ref([])
const messages = [
  "😂 Muito engraçado!",
  "🤣 Você ganhou!",
  "😆 Incrível!",
  "😹 Que jogada!",
  "🎉 Parabéns!",
  "👏 Impressionante!",
  "🙌 Você arrasou!",
  "🤩 Fantástico!"
]

let emojiId = 0
let animationInterval

const createEmoji = () => {
  const newEmoji = {
    id: emojiId++,
    content: messages[Math.floor(Math.random() * messages.length)],
    x: 80,
    y: 0,
    opacity: 1
  }
  emojis.value.push(newEmoji)
  
  const animateEmoji = () => {
    newEmoji.y += 1
    newEmoji.opacity -= 0.02
    if (newEmoji.opacity <= 0) {
      emojis.value = emojis.value.filter(e => e.id !== newEmoji.id)
    } else {
      requestAnimationFrame(animateEmoji)
    }
  }
  animateEmoji(newEmoji)
  requestAnimationFrame(animateEmoji)
}

onMounted(() => {
  animationInterval = setInterval(createEmoji, 200)
})

onUnmounted(() => {
  clearInterval(animationInterval)
})
</script>

<style scoped>
.emoji-enter-active,
.emoji-leave-active {
  transition: all 1.5s ease-out;
}
.emoji-enter-from,
.emoji-leave-to {
  opacity: 0;
  transform: translateY(50px);
}
</style>

<template>
  <div class="absolute inset-0 pointer-events-none overflow-hidden">
    <TransitionGroup name="emoji" tag="div">
      <div
        v-for="emoji in emojis"
        :key="emoji.id"
        class="absolute text-2xl"
        :style="{
          left: `${emoji.x}%`,
          bottom: `${emoji.y}%`,
          opacity: emoji.opacity
        }"
      >
        {{ emoji.content }}
      </div>
    </TransitionGroup>
  </div>
</template>