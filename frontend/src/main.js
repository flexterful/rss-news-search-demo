import { createApp } from 'vue'
import vClickOutside from 'v-click-outside'
import App from './App.vue'

const app = createApp(App)

app.use(vClickOutside)
app.mount('#app')
