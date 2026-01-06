import { createApp } from 'vue'
import App from './App.vue'
import Count from './Count.vue'
import router from './router'
//App.mount('#app')
const app = createApp(App)
app.use(router);
app.mount('#app')
