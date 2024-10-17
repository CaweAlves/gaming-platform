// composables/useAnimation.js
import { ref, onMounted, onUnmounted } from 'vue'

export function useAnimation(interval = 100) {
    const isAnimating = ref(true)

    let animationInterval
    onMounted(() => {
        animationInterval = setInterval(() => {
            isAnimating.value = !isAnimating.value
        }, interval)
    })

    onUnmounted(() => {
        clearInterval(animationInterval)
    })

    return { isAnimating }
}