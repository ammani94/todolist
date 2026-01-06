import { createApp } from 'vue'
import App from './App.vue'
import Count from './Count.vue'
import router from './router'
//App.mount('#app')
createApp(App).use(router);
//const app = createApp(App)


//app.mount('#app')
createApp(App).mount('#app')
