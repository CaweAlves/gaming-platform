// composables/useFloatingItems.js
import { ref, onMounted, onUnmounted } from 'vue'

export function useFloatingItems() {
    const floatingItems = ref([
        { id: 1, content: "🎮", x: 5, y: 14, rotation: 10 },
        { id: 1, content: "🎮", x: 25, y: 60, rotation: 10 },
        { id: 1, content: "🎮", x: 40, y: 20, rotation: 10 },
        { id: 1, content: "🎮", x: 55, y: 70, rotation: 10 },
        { id: 2, content: "🛩", x: 30, y: 15, rotation: 44 },
        { id: 2, content: "", x: 80, y: 55, rotation: 45 },
        { id: 2, content: "✈️", x: 80, y: 5, rotation: 40 },
        { id: 2, content: "🎈", x: 50, y: 90, rotation: 290 },
        { id: 2, content: "🚁", x: 80, y: 65, rotation: 40 },
        { id: 2, content: "🚁", x: 64, y: 75, rotation: 70 },
        { id: 2, content: "✈️", x: 80, y: 15, rotation: 165 },
        { id: 3, content: "🚀", x: 15, y: 43, rotation: 32 },
        { id: 3, content: "🛸", x: 20, y: 75, rotation: 23 },
        { id: 3, content: "🚀", x: 75, y: 80, rotation: 247 },
        { id: 3, content: "🌍", x: 70, y: 20, rotation: 67 },
        { id: 3, content: "🛸", x: 15, y: 30, rotation: 83 },
        { id: 3, content: "🚀", x: 26, y: 86, rotation: 15 },
        { id: 3, content: "🌍", x: 25, y: 10, rotation: 5 },
        { id: 4, content: "🏎", x: 75, y: 70, rotation: 170 },
        { id: 5, content: "🏆", x: 10, y: 40, rotation: 232 },
        { id: 6, content: "🏎", x: 85, y: 60, rotation: 145 },
        { id: 7, content: "🌟", x: 90, y: 30, rotation: 84 },
        { id: 8, content: "🏎", x: 20, y: 4, rotation: 242 },
        { id: 8, content: "🏎", x: 20, y: 12, rotation: 125 },
        { id: 8, content: "🕹", x: 60, y: 20, rotation: 10 },
        { id: 8, content: "🕹", x: 40, y: 80, rotation: 85 },
        { id: 8, content: "🕹", x: 60, y: 44, rotation: 65 },
        { id: 8, content: "🕹", x: 50, y: 50, rotation: 5 },
    ])

    const animateItems = () => {
        floatingItems.value.forEach(item => {
            item.x = Math.random() * 90 + 5
            item.y = Math.random() * 90 + 5
            item.rotation = Math.random() * 360
        })
    }

    let animationInterval

    onMounted(() => {
        animationInterval = setInterval(animateItems, 9500)
    })

    onUnmounted(() => {
        clearInterval(animationInterval)
    })

    return { floatingItems }
}