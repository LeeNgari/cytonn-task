import { createApp } from 'vue'
import { createPinia } from 'pinia'
import './index.css' // Assuming index.css is where Tailwind directives are
import App from './App.vue'
import router from './router'
import { useAuthStore } from './stores/auth'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

// Initialize auth store to check for existing token/user
const authStore = useAuthStore()
authStore.initializeAuth()

app.mount('#app')