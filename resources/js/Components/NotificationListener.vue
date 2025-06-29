<template>
    <div class="p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-bold">Gelen Bildirim:</h2>
        <p>{{ message }}</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Echo from 'laravel-echo'

// Kullanıcı ve token meta tag üzerinden alınır
const userId = "0197bd15-7d7f-73a8-9ea8-dfd32c18295d";
const token = "1|uUrZbcZUJnJ4ScOOdDJU3YyFHrsQD3M2pwIpYYQ964c205fd"

const message = ref('Henüz bildirim yok')

onMounted(() => {
    const echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }
    })

    echo.private(`notification.${userId}`)
        .listen('.notification', (e) => {
            console.log('Bildirim alındı:', e)
            message.value = e.data.merhaba
        })
})
</script>
