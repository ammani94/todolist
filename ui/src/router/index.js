import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import AboutView from '../views/AboutView.vue';
import ContactView from '../views/ContactView.vue';
import AuthenticationView from '../views/AuthenticationView.vue';

const routes = [
  { path: '/', name: 'authentification', component: AuthenticationView, meta: { hideHeader: true } },
  { path: '/home', name: 'home', component: HomeView },
  { path: '/about', name: 'about', component: AboutView },
  { path: '/contact', name: 'contact', component: ContactView },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
