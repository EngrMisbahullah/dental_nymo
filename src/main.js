import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
// import './components/styles.css';
import '@fortawesome/fontawesome-free/css/all.min.css';

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

// Permission directives will be registered after mount
// to ensure Pinia is fully initialized

app.mount('#app')

// Register permission directives after app is mounted
import('./directives/permission').then(({ registerPermissionDirectives }) => {
  registerPermissionDirectives(app)
})
